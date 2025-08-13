<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Menu::insert([
            ['title' => 'Home', 'url' => '/', 'order' => 1],
            ['title' => 'About', 'url' => '/about', 'order' => 2],
            ['title' => 'Prayer Times', 'url' => '/prayers', 'order' => 3],
            ['title' => 'Donate', 'url' => '/donate', 'order' => 4],
            ['title' => 'Contact', 'url' => '/contact', 'order' => 5],
        ]);
    }

}
