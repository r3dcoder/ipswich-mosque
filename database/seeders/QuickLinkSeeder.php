<?php

namespace Database\Seeders;

use App\Models\QuickLink;
use Illuminate\Database\Seeder;

class QuickLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quickLinks = [
            [
                'title' => 'Khutbah',
                'description' => 'Access Friday sermon archives and resources',
                'url' => '/khutbah',
                'icon' => 'book',
                'color' => 'green',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Duas',
                'description' => 'Daily supplications and prayers',
                'url' => '/duas',
                'icon' => 'heart',
                'color' => 'blue',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Basic Principles of Islam',
                'description' => 'Learn the fundamentals of our faith',
                'url' => '/principles-of-islam',
                'icon' => 'building',
                'color' => 'amber',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($quickLinks as $link) {
            QuickLink::create($link);
        }
    }
}