<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'is_active',
        'order',
        'is_imported'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get the category that owns the menu item.
     */
    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    /**
     * Scope a query to only include active items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by the order field.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
    public function getDisplayImageAttribute()
    {
        $categorySlug = $this->category ? $this->category->slug : 'misc';
        $itemSlug = \Illuminate\Support\Str::slug($this->name);
        $extensions = ['jpg', 'jpeg', 'png', 'webp']; // added jpg support

        // Check specific category folder
        foreach ($extensions as $ext) {
            $path = "assets/images/main/menu/{$categorySlug}/{$itemSlug}.{$ext}";
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        // Fallback to database image
        if ($this->image) {
            return asset($this->image);
        }

        // Default fallback
        return asset('assets/images/main/menu/01.png');
    }
}
