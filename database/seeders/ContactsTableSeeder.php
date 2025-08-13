<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    public function run()
    {
        $contacts = [
            ['type' => 'phone', 'value' => '020 1234 5678'],
            ['type' => 'email', 'value' => 'info@mosque.org'],
            ['type' => 'address', 'value' => '123 Mosque Road, Ipswich, IP1 1AA'],
            ['type' => 'facebook', 'value' => 'https://facebook.com/ipswichmosque'],
            ['type' => 'twitter', 'value' => 'https://twitter.com/ipswichmosque'],
        ];

        foreach ($contacts as $contact) {
            Contact::updateOrCreate(['type' => $contact['type']], $contact);
        }
    }
}