<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'site_name' => 'Manam Catering Service',
            'site_description' => 'Find out professional caterers in your city for your Dream Events.',
            'phone' => '+91 9292 8484 000',
            'email' => 'info@manamcatering.com',
            'address' => 'Victoria Island Lagos Nigeria',
            'facebook_url' => '#',
            'twitter_url' => '#',
            'instagram_url' => '#',
            'youtube_url' => '#',
            'google_map_embed' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7929.383324299389!2d3.426551!3d6.433638!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf52931db51f1%3A0xebccb6fc0bd61e40!2s19%20Engineering%20Close%2C%20Victoria%20Island%2C%20Lagos%2C%20Nigeria!5e0!3m2!1sen!2sin!4v1623326034824!5m2!1sen!2sin',
            'footer_text' => '© 2026 Manam Catering Service. All Rights Reserved.',
        ]);
    }
}
