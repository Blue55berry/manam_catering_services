<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'quotation_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'event_type',
        'event_date',
        'guest_count',
        'items',
        'subtotal',
        'tax',
        'discount',
        'total',
        'notes',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
        'event_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Auto-generate quotation number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quotation) {
            if (empty($quotation->quotation_number)) {
                $quotation->quotation_number = 'QT-' . date('Ymd') . '-' . str_pad(static::max('id') + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Get formatted total amount
    public function getFormattedTotalAttribute()
    {
        return '₹' . number_format($this->total, 2);
    }

    // Get formatted subtotal
    public function getFormattedSubtotalAttribute()
    {
        return '₹' . number_format($this->subtotal, 2);
    }

    // Relationship to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Scope for client quotations (linked to bookings)
    public function scopeClientQuotations($query)
    {
        return $query->whereNotNull('booking_id');
    }

    // Scope for manual quotations (not linked to bookings)
    public function scopeManualQuotations($query)
    {
        return $query->whereNull('booking_id');
    }
}
