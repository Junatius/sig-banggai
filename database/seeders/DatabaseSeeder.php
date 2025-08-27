<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attraction;
use App\Models\Event;
use App\Models\Galery;
use App\Models\News;
use App\Models\Subdistrict;
use App\Models\Tourist;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Subdistrict::factory(10)->create();
        Attraction::factory(50)->create();
        Tourist::factory(100)->create();
        
        User::create([
            'username' => 'Admin Pariwisata',
            'email' => 'pariwisata@gmail.com',
            'role' => 'dinas_pariwisata',
            'photo_profile' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'username' => 'Admin Dinas',
            'email' => 'dinas@gmail.com',
            'role' => 'dinas_pariwisata',
            'photo_profile' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'username' => 'Admin Pengelola',
            'email' => 'pengelola@gmail.com',
            'attractions_id' => Attraction::inRandomOrder()->first()->id,
            'role' => 'pengelola',
            'photo_profile' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'remember_token' => Str::random(10),
        ]);

        User::factory(10)->create();
        Galery::factory(20)->create();
        News::factory(20)->create();
        Event::factory(20)->create();
    }
}
