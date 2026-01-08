<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'ticket_price', // Updated to snake_case
        'organizer',
        'is_virtual',   // Updated to snake_case
        'stream_url',   // Updated to snake_case
        'is_free',      // Updated to snake_case
        'created_by_id', // Updated to snake_case
        'category',
        'uuid',
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_virtual' => 'boolean',   // Updated to snake_case
        'is_free' => 'boolean',      // Updated to snake_case
        'ticket_price' => 'integer', // Updated to snake_case
    ];

    /**
     * Boot the model and generate UUID on creation.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get the user who created the event.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id'); // Updated to snake_case
    }

    /**
     * Get the payments associated with this event.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'event_id'); // Updated to snake_case
    }

    /**
     * Get the tickets purchased for this event.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id'); // Updated to snake_case
    }
}
