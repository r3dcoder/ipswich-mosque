<?php

namespace App\Http\Controllers;

use App\Models\Khutbah;
use App\Services\YouTubeService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class KhutbahController extends Controller
{
    /**
     * Display the Khutbah library page.
     * Combines database entries with YouTube channel videos.
     */
    public function index(Request $request, YouTubeService $youtubeService)
    {
        $category = $request->input('category', 'all');
        
        // Get featured khutbah from database (first one)
        $featuredKhutbah = Khutbah::active()
            ->featured()
            ->ordered()
            ->first();
        
        // If no featured khutbah, get the latest one
        if (!$featuredKhutbah) {
            $featuredKhutbah = Khutbah::active()
                ->ordered()
                ->first();
        }
        
        // Get all active khutbahs from database
        $databaseKhutbahs = Khutbah::active()
            ->category($category)
            ->ordered()
            ->get();
        
        // Get YouTube videos if API is configured
        $youtubeVideos = [];
        $liveStream = null;
        $upcomingStreams = [];
        
        if ($youtubeService->isConfigured()) {
            try {
                // Get live stream if any
                $liveStream = $youtubeService->getLiveStream();
                
                // Get upcoming streams
                $upcomingStreams = $youtubeService->getUpcomingStreams(3);
                
                // Get recent videos from YouTube
                $youtubeVideos = $youtubeService->getChannelVideos(30, true);
                
                // Filter out videos that already exist in database (by youtube_id)
                $existingYoutubeIds = $databaseKhutbahs->pluck('youtube_id')->filter()->toArray();
                $youtubeVideos = array_filter($youtubeVideos, function($video) use ($existingYoutubeIds) {
                    return !in_array($video['youtube_id'], $existingYoutubeIds);
                });
                
            } catch (\Exception $e) {
                Log::error('Error fetching YouTube videos: ' . $e->getMessage());
                // Continue with database videos only
            }
        }
        
        // Combine database khutbahs and YouTube videos
        $combinedVideos = $this->combineVideos($databaseKhutbahs, $youtubeVideos);
        
        // Paginate the combined results
        $perPage = 12;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedVideos = array_slice($combinedVideos, $offset, $perPage);
        
        // Create a paginator instance
        $khutbahs = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedVideos,
            count($combinedVideos),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        // Get featured khutbahs for the series section (database only)
        $featuredSeries = Khutbah::active()
            ->featured()
            ->ordered()
            ->take(8)
            ->get();
        
        // Get only categories that have videos (from both database and YouTube)
        $allCategories = Khutbah::categories();
        $usedCategories = array_unique(array_column($combinedVideos, 'category'));
        $categories = array_filter($allCategories, function($key) use ($usedCategories) {
            return in_array($key, $usedCategories);
        }, ARRAY_FILTER_USE_KEY);
        
        return view('khutbah', compact(
            'featuredKhutbah', 
            'khutbahs', 
            'featuredSeries', 
            'categories', 
            'category',
            'liveStream',
            'upcomingStreams'
        ));
    }

    /**
     * Combine database khutbahs with YouTube videos into a unified collection.
     * Database entries take precedence and appear first.
     */
    private function combineVideos(Collection $databaseKhutbahs, array $youtubeVideos): array
    {
        $combined = [];
        
        // Add database khutbahs first
        foreach ($databaseKhutbahs as $khutbah) {
            $combined[] = [
                'id' => $khutbah->id,
                'youtube_id' => $khutbah->youtube_id,
                'title' => $khutbah->title,
                'description' => $khutbah->description,
                'thumbnail_url' => $khutbah->thumbnail_url,
                'speaker' => $khutbah->speaker,
                'category' => $khutbah->category,
                'category_label' => $khutbah->category_label,
                'delivered_date' => $khutbah->delivered_date,
                'formatted_date' => $khutbah->formatted_date,
                'duration' => $khutbah->duration,
                'formatted_duration' => $khutbah->formatted_duration,
                'is_featured' => $khutbah->is_featured,
                'is_active' => $khutbah->is_active,
                'is_live' => false,
                'is_upcoming' => false,
                'source' => 'database',
                'published_at' => $khutbah->created_at?->toDateTimeString(),
            ];
        }
        
        // Add YouTube videos with auto-detected categories
        foreach ($youtubeVideos as $video) {
            // Detect category from title
            $categoryInfo = app(\App\Services\YouTubeService::class)->detectCategory($video['title']);
            
            $combined[] = [
                'id' => null,
                'youtube_id' => $video['youtube_id'],
                'title' => $video['title'],
                'description' => $video['description'] ?? '',
                'thumbnail_url' => $video['thumbnail_url'] ?? "https://img.youtube.com/vi/{$video['youtube_id']}/maxresdefault.jpg",
                'speaker' => null,
                'category' => $categoryInfo['category'],
                'category_label' => $categoryInfo['category_label'],
                'delivered_date' => null,
                'formatted_date' => isset($video['published_at']) ? (new \DateTime($video['published_at']))->format('M d, Y') : '',
                'duration' => null,
                'formatted_duration' => '',
                'is_featured' => false,
                'is_active' => true,
                'is_live' => $video['is_live'] ?? false,
                'is_upcoming' => $video['is_upcoming'] ?? false,
                'source' => 'youtube',
                'published_at' => $video['published_at'] ?? null,
            ];
        }
        
        // Sort by date (most recent first)
        usort($combined, function($a, $b) {
            $dateA = $a['published_at'] ?? $a['formatted_date'] ?? '';
            $dateB = $b['published_at'] ?? $b['formatted_date'] ?? '';
            return strtotime($dateB) - strtotime($dateA);
        });
        
        return $combined;
    }
}