<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class YouTubeService
{
    private string $apiKey;
    private string $channelHandle;
    private string $baseUrl = 'https://www.googleapis.com/youtube/v3';

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key', '');
        $this->channelHandle = config('services.youtube.channel_handle', '@ipswichmosque1980');
    }

    /**
     * Get the channel ID from the channel handle
     */
    public function getChannelId(): ?string
    {
        $cacheKey = 'youtube_channel_id_' . md5($this->channelHandle);
        
        return Cache::remember($cacheKey, 86400, function () {
            try {
                $response = Http::get("{$this->baseUrl}/channels", [
                    'part' => 'id',
                    'forHandle' => $this->channelHandle,
                    'key' => $this->apiKey,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['items']) && count($data['items']) > 0) {
                        return $data['items'][0]['id'];
                    }
                }

                // Fallback: Try searching for the channel
                return $this->searchChannel();
            } catch (Exception $e) {
                Log::error('YouTube API Error - Getting Channel ID: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Search for the channel as a fallback
     */
    private function searchChannel(): ?string
    {
        try {
            $response = Http::get("{$this->baseUrl}/search", [
                'part' => 'snippet',
                'q' => 'Ipswich Mosque',
                'type' => 'channel',
                'maxResults' => 1,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['items']) && count($data['items']) > 0) {
                    return $data['items'][0]['id']['channelId'];
                }
            }
        } catch (Exception $e) {
            Log::error('YouTube API Error - Searching Channel: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get videos from the channel
     * 
     * @param int $maxResults Maximum number of videos to fetch
     * @param bool $includeLive Whether to include live streams
     * @return array
     */
    public function getChannelVideos(int $maxResults = 20, bool $includeLive = true): array
    {
        if (empty($this->apiKey)) {
            Log::warning('YouTube API key not configured');
            return [];
        }

        $channelId = $this->getChannelId();
        if (!$channelId) {
            Log::warning('YouTube channel ID not found for: ' . $this->channelHandle);
            return [];
        }

        $cacheKey = 'youtube_videos_' . md5($channelId . '_' . $maxResults . '_' . ($includeLive ? 'live' : 'no-live'));
        
        return Cache::remember($cacheKey, 3600, function () use ($channelId, $maxResults, $includeLive) {
            try {
                // First, get regular videos (completed)
                $response = Http::get("{$this->baseUrl}/search", [
                    'part' => 'snippet',
                    'channelId' => $channelId,
                    'order' => 'date',
                    'type' => 'video',
                    'maxResults' => $maxResults,
                    'eventType' => 'completed',
                    'key' => $this->apiKey,
                ]);

                $videos = [];
                if ($response->successful()) {
                    $data = $response->json();
                    $videos = $this->parseVideoResults($data['items'] ?? []);
                }

                // Also fetch past live streams specifically
                if ($includeLive) {
                    $liveResponse = Http::get("{$this->baseUrl}/search", [
                        'part' => 'snippet',
                        'channelId' => $channelId,
                        'order' => 'date',
                        'type' => 'video',
                        'maxResults' => 10,
                        'eventType' => 'completed',
                        'key' => $this->apiKey,
                    ]);

                    if ($liveResponse->successful()) {
                        $liveData = $liveResponse->json();
                        $liveVideos = $this->parseVideoResults($liveData['items'] ?? []);
                        
                        // Merge and remove duplicates
                        $existingIds = array_column($videos, 'youtube_id');
                        foreach ($liveVideos as $video) {
                            if (!in_array($video['youtube_id'], $existingIds)) {
                                $videos[] = $video;
                            }
                        }
                        
                        // Sort by date and limit
                        usort($videos, function($a, $b) {
                            return strtotime($b['published_at'] ?? 0) - strtotime($a['published_at'] ?? 0);
                        });
                        $videos = array_slice($videos, 0, $maxResults);
                    }
                }

                return $videos;
            } catch (Exception $e) {
                Log::error('YouTube API Error - Getting Videos: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Check if there's a current live stream
     */
    public function getLiveStream(): ?array
    {
        if (empty($this->apiKey)) {
            return null;
        }

        $channelId = $this->getChannelId();
        if (!$channelId) {
            return null;
        }

        try {
            $response = Http::get("{$this->baseUrl}/search", [
                'part' => 'snippet',
                'channelId' => $channelId,
                'order' => 'date',
                'type' => 'video',
                'eventType' => 'live',
                'maxResults' => 1,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['items']) && count($data['items']) > 0) {
                    $videos = $this->parseVideoResults($data['items']);
                    return $videos[0] ?? null;
                }
            }
        } catch (Exception $e) {
            Log::error('YouTube API Error - Getting Live Stream: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get upcoming scheduled streams
     */
    public function getUpcomingStreams(int $maxResults = 5): array
    {
        if (empty($this->apiKey)) {
            return [];
        }

        $channelId = $this->getChannelId();
        if (!$channelId) {
            return [];
        }

        try {
            $response = Http::get("{$this->baseUrl}/search", [
                'part' => 'snippet',
                'channelId' => $channelId,
                'order' => 'date',
                'type' => 'video',
                'eventType' => 'upcoming',
                'maxResults' => $maxResults,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $this->parseVideoResults($data['items'] ?? []);
            }
        } catch (Exception $e) {
            Log::error('YouTube API Error - Getting Upcoming Streams: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Parse video results from YouTube API
     */
    private function parseVideoResults(array $items): array
    {
        $videos = [];
        
        foreach ($items as $item) {
            $videoId = $item['id']['videoId'] ?? null;
            if (!$videoId) {
                continue;
            }

            $snippet = $item['snippet'] ?? [];
            $publishedAt = $snippet['publishTime'] ?? $snippet['publishedAt'] ?? null;
            
            // Get video details including live status
            $broadcastContent = $snippet['liveBroadcastContent'] ?? 'none';
            $isLive = $broadcastContent === 'live';
            $isUpcoming = $broadcastContent === 'upcoming';
            $wasLive = $broadcastContent === 'none' && $this->isPastLiveStream($snippet['title'] ?? '');

            // Format the date for display
            $formattedDate = '';
            if ($publishedAt) {
                try {
                    $date = new \DateTime($publishedAt);
                    $formattedDate = $date->format('M d, Y');
                } catch (\Exception $e) {
                    $formattedDate = '';
                }
            }

            $videos[] = [
                'youtube_id' => $videoId,
                'title' => $snippet['title'] ?? 'Untitled',
                'description' => $snippet['description'] ?? '',
                'thumbnail_url' => ($snippet['thumbnails']['high'] ?? $snippet['thumbnails']['medium'] ?? $snippet['thumbnails']['default'])['url'] ?? null,
                'published_at' => $publishedAt,
                'formatted_date' => $formattedDate,
                'is_live' => $isLive,
                'is_upcoming' => $isUpcoming,
                'was_live' => $wasLive,
                'source' => 'youtube',
            ];
        }

        return $videos;
    }

    /**
     * Check if a video title suggests it was a past live stream
     */
    private function isPastLiveStream(string $title): bool
    {
        $title = strtolower($title);
        $liveIndicators = [
            'live',
            'jumu\'ah',
            'friday prayer',
            'jummah',
            'khutbah',
            'live stream',
            'was live',
        ];
        
        foreach ($liveIndicators as $indicator) {
            if (strpos($title, $indicator) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get video details including duration
     */
    public function getVideoDetails(string $videoId): ?array
    {
        if (empty($this->apiKey)) {
            return null;
        }

        try {
            $response = Http::get("{$this->baseUrl}/videos", [
                'part' => 'snippet,contentDetails',
                'id' => $videoId,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['items']) && count($data['items']) > 0) {
                    $item = $data['items'][0];
                    $snippet = $item['snippet'];
                    $contentDetails = $item['contentDetails'] ?? [];
                    
                    return [
                        'youtube_id' => $videoId,
                        'title' => $snippet['title'] ?? 'Untitled',
                        'description' => $snippet['description'] ?? '',
                        'thumbnail_url' => ($snippet['thumbnails']['high'] ?? $snippet['thumbnails']['medium'] ?? $snippet['thumbnails']['default'])['url'] ?? null,
                        'published_at' => $snippet['publishedAt'] ?? null,
                        'duration' => $contentDetails['duration'] ?? null,
                        'source' => 'youtube',
                    ];
                }
            }
        } catch (Exception $e) {
            Log::error('YouTube API Error - Getting Video Details: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Convert ISO 8601 duration to minutes
     */
    public function parseDuration(string $duration): int
    {
        $interval = new \DateInterval($duration);
        return ($interval->h * 60) + $interval->i;
    }

    /**
     * Format date for display
     */
    public function formatDate(string $dateString): string
    {
        try {
            $date = new \DateTime($dateString);
            return $date->format('M d, Y');
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Check if API is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }
}