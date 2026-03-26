<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\People;

class PeopleSeeder extends Seeder
{
    public function run()
    {
        People::create([
            'name' => 'Imam Ahmed',
            'image_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
            'phone' => '+44 1234 567890',
            'email' => 'imam@ipswichmosque.org',
            'role' => 'Imam'
        ]);

        People::create([
            'name' => 'Sarah Johnson',
            'image_url' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
            'phone' => '+44 1234 567891',
            'email' => 'sarah@ipswichmosque.org',
            'role' => 'Administrator'
        ]);

        People::create([
            'name' => 'Mohammed Ali',
            'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
            'phone' => '+44 1234 567892',
            'email' => 'mohammed@ipswichmosque.org',
            'role' => 'Teacher'
        ]);

        People::create([
            'name' => 'Fatima Hassan',
            'image_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
            'phone' => '+44 1234 567893',
            'email' => 'fatima@ipswichmosque.org',
            'role' => 'Volunteer Coordinator'
        ]);
    }
}