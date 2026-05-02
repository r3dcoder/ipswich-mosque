<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Services Menu Items
        $servicesParent = MenuItem::create([
            'title' => 'Our Services',
            'url' => null,
            'parent_id' => null,
            'menu_group' => 'services',
            'sort_order' => 0,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        // Services sub-items
        MenuItem::create([
            'title' => 'Ramadan',
            'url' => '/ramadan',
            'parent_id' => $servicesParent->id,
            'menu_group' => 'services',
            'sort_order' => 0,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        MenuItem::create([
            'title' => 'Marriage (Nikah)',
            'url' => '/services/marriage',
            'parent_id' => $servicesParent->id,
            'menu_group' => 'services',
            'sort_order' => 1,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        MenuItem::create([
            'title' => 'Funeral (Janazah)',
            'url' => '/services/janazah',
            'parent_id' => $servicesParent->id,
            'menu_group' => 'services',
            'sort_order' => 2,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        MenuItem::create([
            'title' => 'Visit Mosque',
            'url' => '/services/visit',
            'parent_id' => $servicesParent->id,
            'menu_group' => 'services',
            'sort_order' => 3,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        // Community Menu Items
        $communityParent = MenuItem::create([
            'title' => 'Community',
            'url' => null,
            'parent_id' => null,
            'menu_group' => 'community',
            'sort_order' => 0,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        // Community sub-items
        MenuItem::create([
            'title' => 'Notice Board',
            'url' => '/notices',
            'parent_id' => $communityParent->id,
            'menu_group' => 'community',
            'sort_order' => 0,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        MenuItem::create([
            'title' => 'Newsletter',
            'url' => '/newsletters',
            'parent_id' => $communityParent->id,
            'menu_group' => 'community',
            'sort_order' => 1,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);

        MenuItem::create([
            'title' => 'Our People',
            'url' => '/people',
            'parent_id' => $communityParent->id,
            'menu_group' => 'community',
            'sort_order' => 2,
            'is_active' => true,
            'open_in_new_tab' => false,
        ]);
    }
}