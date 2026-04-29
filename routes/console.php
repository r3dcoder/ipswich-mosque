<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring->quote());
})->purpose('Display an inspiring quote');

// Sync YouTube videos every Friday at 2 PM (after Jumu'ah prayers)
Schedule::command('youtube:sync-khutbahs --limit=10')
    ->fridays()
    ->at('14:00')
    ->withoutOverlapping();

// Also sync every day at 6 PM to catch any new uploads
Schedule::command('youtube:sync-khutbahs --limit=5')
    ->dailyAt('18:00')
    ->withoutOverlapping();
