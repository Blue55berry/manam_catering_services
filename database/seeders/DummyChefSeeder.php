<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyChefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing to avoid duplicates if needed, or just append. 
        // Note: In production normally we don't truncate, but for a "dummy data setup" request it's often cleaner.
        // Let's just create them.
        
        $chefs = [
            [
                'name' => 'Sanjeev Nair',
                'role' => 'Executive Chef',
                'image' => 'https://images.unsplash.com/photo-1583394293214-28ded15ee548?auto=format&fit=crop&q=80&w=800', // Male chef
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://instagram.com',
                'is_active' => true,
                'order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Meera Iyer',
                'role' => 'Head of Pastry',
                'image' => 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&q=80&w=800', // Female chef or similar
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://instagram.com',
                'is_active' => true,
                'order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rajesh Kumar',
                'role' => 'Tandoor Specialist',
                'image' => 'https://images.unsplash.com/photo-1566554273541-37a9ca77b91f?auto=format&fit=crop&q=80&w=800', // Chef working
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://instagram.com',
                'is_active' => true,
                'order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Anjali Devi',
                'role' => 'South Indian Cuisine Lead',
                'image' => 'https://images.unsplash.com/photo-1569618170669-7c28bb220803?auto=format&fit=crop&q=80&w=800', // Person cooking
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://instagram.com',
                'is_active' => true,
                'order' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('team_members')->insert($chefs);
    }
}
