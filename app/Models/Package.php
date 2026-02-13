<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'features',
        'menu_content',
        'is_active',
        'image'
    ];

    protected $casts = [
        'features' => 'array',
        'menu_content' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];
}
