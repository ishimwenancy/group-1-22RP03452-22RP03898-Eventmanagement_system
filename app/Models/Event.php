<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'price',
        'requirements',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    protected $appends = [
        'available_slots',
    ];

    public function category()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->capacity - $this->bookings_count);
    }

    public function isUpcoming(): bool
    {
        return $this->start_date->isFuture();
    }

    public function hasStarted(): bool
    {
        return $this->start_date->isPast();
    }

    public function hasEnded(): bool
    {
        return $this->end_date->isPast();
    }

    public function isSoldOut(): bool
    {
        return $this->available_slots <= 0;
    }

    public function canBook(): bool
    {
        return !$this->hasStarted() && !$this->isSoldOut();
    }
}
