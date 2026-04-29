<?php

namespace App\Console\Commands;

use App\Models\Khutbah;
use App\Services\YouTubeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncYouTubeVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:sync-khutbahs {--limit=20 : Maximum number of videos to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync YouTube channel videos to the Khutbah database';

    private YouTubeService $youtubeService;

    public function handle(YouTubeService $youtubeService): int
    {
        $this->youtubeService = $youtubeService;

        if (!$this->youtubeService->isConfigured()) {
            $this->error('YouTube API is not configured. Please add YOUTUBE_API_KEY to your .env file.');
            return Command::FAILURE;
        }

        $limit = $this->option('limit');
        $this->info("Starting YouTube video sync (limit: {$limit})...");

        // Get videos from YouTube
        $videos = $this->youtubeService->getChannelVideos($limit, true);

        if (empty($videos)) {
            // Check if this is a quota exceeded error
            if ($this->youtubeService->checkQuotaError()) {
                $this->error('YouTube API quota exceeded. The daily API limit has been reached.');
                $this->info('Please try again later or consider increasing your API quota in Google Cloud Console.');
                $this->info('Quota resets daily. Visit: https://console.cloud.google.com/apis/api/youtube.googleapis.com/quotas');
                return Command::FAILURE;
            }
            
            $this->warn('No videos found or unable to fetch from YouTube.');
            return Command::SUCCESS;
        }

        $this->info("Found " . count($videos) . " videos from YouTube channel.");

        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($videos as $video) {
            // Check if video already exists in database
            $existingKhutbah = Khutbah::where('youtube_id', $video['youtube_id'])->first();

            if ($existingKhutbah) {
                // Update existing record
                $this->updateKhutbah($existingKhutbah, $video);
                $updated++;
                $this->line("  Updated: {$video['title']}");
            } else {
                // Create new record
                $this->createKhutbah($video);
                $created++;
                $this->line("  Created: {$video['title']}");
            }
        }

        $this->info("Sync completed! Created: {$created}, Updated: {$updated}, Skipped: {$skipped}");
        
        // Clear the video cache
        cache()->forget('youtube_videos_' . md5($this->youtubeService->getChannelId() . '_' . $limit . '_live'));
        
        return Command::SUCCESS;
    }

    private function createKhutbah(array $video): void
    {
        $data = [
            'title' => $this->cleanTitle($video['title']),
            'description' => $video['description'] ?? null,
            'youtube_url' => "https://www.youtube.com/watch?v={$video['youtube_id']}",
            'youtube_id' => $video['youtube_id'],
            'thumbnail_url' => $video['thumbnail_url'] ?? "https://img.youtube.com/vi/{$video['youtube_id']}/maxresdefault.jpg",
            'speaker' => 'Ipswich Mosque',
            'category' => 'general',
            'delivered_date' => isset($video['published_at']) ? date('Y-m-d', strtotime($video['published_at'])) : now(),
            'duration' => null,
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 0,
        ];

        Khutbah::create($data);
    }

    private function updateKhutbah(Khutbah $khutbah, array $video): void
    {
        $khutbah->update([
            'title' => $this->cleanTitle($video['title']),
            'description' => $video['description'] ?? $khutbah->description,
            'thumbnail_url' => $video['thumbnail_url'] ?? $khutbah->thumbnail_url,
        ]);
    }

    private function cleanTitle(string $title): string
    {
        // Remove common YouTube title patterns
        $patterns = [
            '/\s*-\s*Live$/',
            '/\s*-\s*Live Stream$/',
            '/\s*\|\s*Ipswich Mosque$/',
            '/\s*-\s*Ipswich Mosque$/',
        ];

        foreach ($patterns as $pattern) {
            $title = preg_replace($pattern, '', $title);
        }

        return trim($title);
    }
}