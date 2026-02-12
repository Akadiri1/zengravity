<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CollabSeeder extends Seeder
{
    public function run()
    {
        $niches = ['Tech Reviews', 'Fitness', 'Urban Fashion', 'Food & Travel', 'AI Education'];
        
        // Create 20 synthetic influencers with distinct Users
        for ($i = 0; $i < 20; $i++) {
            // Create a dummy user first to satisfy Foreign Key
            $user = User::factory()->create([
                'name' => 'Influencer ' . $i,
                'email' => 'influencer' . $i . '@example.com',
                'password' => bcrypt('password'), // standard password
            ]);

            DB::table('collabs')->insert([
                'user_id' => $user->id, 
                'niche' => $niches[array_rand($niches)],
                'bio_summary' => 'Hi, I am ' . $user->name . ', an influencer interested in ' . $niches[array_rand($niches)] . ' and collaborative content.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
