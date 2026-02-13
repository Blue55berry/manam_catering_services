<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'country',
        'event_id',
        'event_type',
        'event_date',
        'guest_count',
        'food_preference',
        'dish_suggestions',
        'special_requests',
        'selected_items',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'event_date' => 'date',
        'guest_count' => 'integer',
    ];

    /**
     * Scope a query to filter by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to get recent bookings first.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get the event associated with this booking.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get quotations related to this booking.
     */
    public function quotations()
    {
        return $this
            ->hasMany(Quotation::class, 'customer_email', 'email')
            ->where('event_date', $this->event_date);
    }
}
