# YouTube Integration Guide for Khutbah Library

This guide explains how to set up automatic YouTube video fetching for the Ipswich Mosque Khutbah Library.

## Overview

The system automatically fetches videos from the Ipswich Mosque YouTube channel (`@ipswichmosque1980`) and displays them on the `/khutbah` page. This includes:

- **Live streams**: Automatically detected and prominently displayed
- **Upcoming streams**: Shown with reminder buttons
- **Past videos**: Displayed in the video grid with YouTube badges

## Setup Instructions

### 1. Get a YouTube Data API Key

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the **YouTube Data API v3**:
   - Go to "APIs & Services" > "Library"
   - Search for "YouTube Data API v3"
   - Click "Enable"
4. Create API Credentials:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "API Key"
   - Copy the generated API key

### 2. Configure the Application

1. Open the `.env` file in your project root
2. Add your YouTube API key:

```env
YOUTUBE_API_KEY=your_api_key_here
YOUTUBE_CHANNEL_HANDLE=@ipswichmosque1980
```

3. Clear the configuration cache:

```bash
php artisan config:clear
```

### 3. Set Up Scheduled Tasks

The system uses Laravel's scheduler to automatically sync videos. Make sure the scheduler is running:

```bash
# Add to your crontab (run once per minute)
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

The scheduler will:
- **Every Friday at 2:00 PM**: Sync 10 videos (after Jumu'ah prayers)
- **Daily at 6:00 PM**: Sync 5 videos (to catch new uploads)

### 4. Manual Sync

You can also manually sync videos using the artisan command:

```bash
# Sync latest 20 videos
php artisan youtube:sync-khutbahs

# Sync with custom limit
php artisan youtube:sync-khutbahs --limit=50
```

## Features

### Automatic Live Stream Detection

When a live stream is active on the YouTube channel:
- A prominent "LIVE NOW" banner appears at the top of the Khutbah page
- The banner pulses with animation to attract attention
- Clicking "Watch Live" opens the stream in the video modal

### Upcoming Stream Notifications

For scheduled upcoming streams:
- An "Upcoming Streams" section appears on the page
- Shows stream title, thumbnail, and scheduled time
- "Set Reminder" button for users

### Video Grid Integration

All YouTube videos are displayed in the video grid with:
- YouTube badge indicator
- Automatic thumbnail fetching
- Published date from YouTube
- Click to play in modal overlay

### Caching

The system caches YouTube API responses to:
- Reduce API quota usage
- Improve page load times
- Cache duration: 1 hour for videos, 24 hours for channel info

## API Quota Management

YouTube Data API has daily quota limits (default: 10,000 units/day). Each API call consumes quota units:

| Operation | Quota Cost |
|-----------|------------|
| Search (list videos) | 100 units |
| Channel info lookup | 1 unit |
| Video details | 161 units |

The system is optimized to:
- Use caching to minimize API calls
- Limit the number of videos fetched per sync
- Only fetch necessary data fields

**Estimated daily quota usage:**
- Channel info lookup: ~1 unit (cached 24 hours)
- Video search (3x daily): ~100 units per call = 300 units
- Total: ~301 units/day (well within the 10,000 unit daily limit)

### Understanding Quota Exceeded Errors

If you see the error **"The request cannot be completed because you have exceeded your quota"**, this means:

1. **Daily limit reached**: The API key has used all 10,000 quota units for the day
2. **Quota resets daily**: The quota automatically resets at midnight Pacific Time (PT)
3. **Common causes**:
   - Too many sync operations in a short period
   - Multiple applications using the same API key
   - Cache not working properly (causing repeated API calls)

**To resolve quota issues:**

1. **Wait for quota reset**: Quota resets daily at midnight PT (approximately 8 hours from now if you're in Europe)

2. **Check cache is working**: The system caches API responses for 1 hour. If cache isn't working, quota will be consumed faster.
   ```bash
   php artisan cache:clear
   ```

3. **Reduce sync frequency**: Edit `routes/console.php` to sync less frequently

4. **Request quota increase**: Go to [Google Cloud Console Quotas](https://console.cloud.google.com/apis/api/youtube.googleapis.com/quotas) to request more quota

5. **Monitor usage**: Check your API usage at [Google Cloud Console](https://console.cloud.google.com/apis/api/youtube.googleapis.com)

## Troubleshooting

### Videos Not Showing

1. Check if API key is configured:
   ```bash
   php artisan tinker
   >>> config('services.youtube.api_key')
   ```

2. Test the API connection:
   ```bash
   php artisan youtube:sync-khutbahs
   ```

3. Check Laravel logs for errors:
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. Check for quota exceeded error:
   ```bash
   # Look for quota errors in logs
   grep -i "quota" storage/logs/laravel.log
   ```

### API Quota Exceeded

If you see quota errors:
1. **Wait for reset**: Quota resets daily at midnight Pacific Time
2. **Reduce sync frequency** in `routes/console.php`
3. **Increase cache duration** in `YouTubeService.php` (default is 3600 seconds = 1 hour)
4. **Request quota increase** from [Google Cloud Console Quotas](https://console.cloud.google.com/apis/api/youtube.googleapis.com/quotas)
5. **Check for cache issues**: Ensure Redis/file caching is working properly

### Channel Not Found

If the channel can't be found:
1. Verify the channel handle is correct: `@ipswichmosque1980`
2. Make sure the channel is public
3. Check that the channel has videos uploaded

## Database Sync

The `youtube:sync-khutbahs` command:
- Creates new Khutbah records for videos not in the database
- Updates existing records with latest titles and thumbnails
- Skips videos that already exist (by YouTube ID)
- Cleans up video titles (removes "Live", "Ipswich Mosque" suffixes)

## Customization

### Change Channel

To use a different YouTube channel:

1. Update `.env`:
   ```env
   YOUTUBE_CHANNEL_HANDLE=@your-channel-handle
   ```

2. Clear cache:
   ```bash
   php artisan config:clear
   ```

### Adjust Sync Frequency

Edit `routes/console.php`:

```php
// Change Friday sync time
Schedule::command('youtube:sync-khutbahs --limit=10')
    ->fridays()
    ->at('15:00')  // Change time here
    ->withoutOverlapping();

// Change daily sync
Schedule::command('youtube:sync-khutbahs --limit=5')
    ->dailyAt('19:00')  // Change time here
    ->withoutOverlapping();
```

### Modify Video Limit

Change the default limit in `app/Console/Commands/SyncYouTubeVideos.php`:

```php
protected $signature = 'youtube:sync-khutbahs {--limit=20 : Maximum number of videos to sync}';
```

## Files Modified/Created

- `app/Services/YouTubeService.php` - YouTube API service
- `app/Http/Controllers/KhutbahController.php` - Updated controller
- `config/services.php` - Added YouTube configuration
- `routes/console.php` - Added scheduled tasks
- `app/Console/Commands/SyncYouTubeVideos.php` - Sync command
- `.env` - Added YouTube configuration variables
- `resources/views/khutbah.blade.php` - Updated view with live stream support

## Support

For issues or questions:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Test API manually: `php artisan youtube:sync-khutbahs`
3. Review YouTube API documentation: https://developers.google.com/youtube/v3

## Production Deployment

Before deploying to production:

1. Set up the scheduler on your production server
2. Add the YouTube API key to production `.env`
3. Clear all caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```
4. Test the sync command manually
5. Monitor the first few automatic syncs

## Security Notes

- Keep your API key secret (never commit to version control)
- Consider restricting the API key to specific referrers in Google Cloud Console
- Monitor API usage in Google Cloud Console to detect unusual activity