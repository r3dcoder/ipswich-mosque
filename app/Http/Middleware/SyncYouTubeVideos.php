<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\YouTubeService;

class SyncYouTubeVideos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only run sync if YouTube API is configured
        $youtubeService = app(YouTubeService::class);
        
        if (!$youtubeService->isConfigured()) {
            return $next($request);
        }

        // Check if we should run the sync (after 3:00 PM)
        $now = now();
        $currentHour = (int) $now->format('G');
        
        // Only sync if it's after 3:00 PM (15:00)
        if ($currentHour < 15) {
            return $next($request);
        }

        // Use a daily cache to prevent multiple syncs per day
        $cacheKey = 'youtube_sync_last_run_' . $now->format('Y-m-d');
        
        if (Cache::has($cacheKey)) {
            // Already synced today
            return $next($request);
        }

        // Mark as synced for today
        Cache::put($cacheKey, true, now()->addHours(24));

        // Run the sync in the background (non-blocking)
        try {
            // For non-blocking execution, we'll use a simple approach
            // The sync will run but won't delay the page load significantly
            $youtubeService->getChannelVideos(20, true);
        } catch (\Exception $e) {
            // Log error but don't interrupt the request
            \Log::error('Background YouTube sync failed: ' . $e->getMessage());
        }

        return $next($request);
    }
}