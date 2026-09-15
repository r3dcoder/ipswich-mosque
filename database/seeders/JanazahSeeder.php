<?php

namespace Database\Seeders;

use App\Models\EmergencyContact;
use App\Models\JanazahContent;
use Illuminate\Database\Seeder;

class JanazahSeeder extends Seeder
{
    /**
     * Seed default Janazah page content and emergency contacts.
     */
    public function run(): void
    {
        // Clear existing so seeder is re-runnable
        JanazahContent::query()->delete();
        EmergencyContact::query()->delete();

        // Hero
        JanazahContent::create([
            'section'    => 'hero',
            'title'      => 'Janazah & Funeral Services',
            'content'    => "\"Inna Lillahi wa inna ilayhi raji'un\"\n\nThe Ipswich Mosque offers full support during difficult times, including body wash (Ghusl) facilities, shrouding (Kafan), and Janazah prayers before burial.",
            'sort_order' => 0,
            'is_visible' => true,
        ]);

        // Funeral Rites
        $rites = [
            ['title' => 'Ghusl',  'content' => 'Ritual Bathing', 'sort_order' => 1],
            ['title' => 'Kafan',  'content' => 'Enshrouding',    'sort_order' => 2],
            ['title' => 'Salah',  'content' => 'Funeral Prayer', 'sort_order' => 3],
            ['title' => 'Dafn',   'content' => 'Burial',         'sort_order' => 4],
            ['title' => 'Qibla',  'content' => 'Facing Makkah',  'sort_order' => 5],
        ];

        foreach ($rites as $rite) {
            JanazahContent::create([
                'section'    => 'rite',
                'title'      => $rite['title'],
                'content'    => $rite['content'],
                'sort_order' => $rite['sort_order'],
                'is_visible' => true,
            ]);
        }

        // Prayer steps
        $prayers = [
            [
                'title'      => 'First Takbeer & Thana',
                'content'    => "Raise hands to earlobes, say \"Allahu Akbar\", and fold hands. Recite Thana with an addition:\n\n\"Subhanakal-lahumma wa bihamdika, wa tabarakasmuka, wa ta'ala jadduka, wa jalla thina'uka, wa la ilaha ghayruk.\"",
                'sort_order' => 1,
            ],
            [
                'title'      => 'Second Takbeer & Durood',
                'content'    => 'Say "Allahu Akbar" (do not raise hands). Recite Durood-e-Ibrahim as in normal Salah.',
                'sort_order' => 2,
            ],
            [
                'title'      => 'Third Takbeer & Dua for Deceased',
                'content'    => "Say \"Allahu Akbar\". Recite the Janazah Dua (for adults):\n\n\"Allahummagh-fir lihayyina wa mayyitina, wa shahidina wa gha'ibina, wa saghirina wa kabirina, wa dhakarina wa unthana...\"",
                'sort_order' => 3,
            ],
            [
                'title'      => 'Fourth Takbeer & Taslim',
                'content'    => 'Say "Allahu Akbar". Then perform Salam to the right and left (as in normal prayer) while dropping the hands to the sides.',
                'sort_order' => 4,
            ],
        ];

        foreach ($prayers as $prayer) {
            JanazahContent::create([
                'section'    => 'prayer',
                'title'      => $prayer['title'],
                'content'    => $prayer['content'],
                'sort_order' => $prayer['sort_order'],
                'is_visible' => true,
            ]);
        }

        // Terms main
        JanazahContent::create([
            'section'    => 'terms',
            'title'      => 'Body Wash Facility Terms & Conditions',
            'content'    => "The following rules are in place for your benefits and also to help us to provide you with a great service.\n\nUsage Policy: Before using the body wash facilities please read this document; it contains what you can expect from us (Ipswich Mosque), what we expect from you in return and guidelines on how to carry out the body wash.\n\nOur Imams will be able to guide you all or part of the way on your request. We will try our best to support and assist you all the way.\n\n* By using these facilities, you agree to these terms. We reserve the right to update this agreement without notice to improve the service.",
            'sort_order' => 0,
            'is_visible' => true,
        ]);

        // Terms points
        JanazahContent::create([
            'section'    => 'terms_point',
            'title'      => 'Agreement',
            'content'    => "• A minimum donation is required to cover costs.\n• We provide the Khapon (Shroud) required for burial.\n• Soap will be provided by the mosque.\n• Imam guidance is available upon request.",
            'sort_order' => 1,
            'is_visible' => true,
        ]);

        JanazahContent::create([
            'section'    => 'terms_point',
            'title'      => 'Room Checklist',
            'content'    => "• Check that the room is clear and tidy.\n• Verify that water is working correctly.\n• Report any issues to the Committee/Imam immediately.",
            'sort_order' => 2,
            'is_visible' => true,
        ]);

        // Emergency contacts
        EmergencyContact::create([
            'name'              => 'Mohammed Tunu Miah',
            'role_in_committee' => 'Funeral Coordinator',
            'phone_number'      => '07855 540993',
            'sort_order'        => 1,
            'is_visible'        => true,
        ]);

        EmergencyContact::create([
            'name'              => 'Mosque Office',
            'role_in_committee' => null,
            'phone_number'      => '01473 226879',
            'sort_order'        => 2,
            'is_visible'        => true,
        ]);
    }
}
