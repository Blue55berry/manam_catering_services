<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_name',
        'site_description',
        'phone',
        'email',
        'address',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'google_map_embed',
        'footer_text',
    ];

    /**
     * Get the singleton site settings instance.
     *
     * @return SiteSetting|null
     */
    public static function get()
    {
        return static::first();
    }
}
