<?php
// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'purchaseDate',  // Actual column name in database (camelCase)
        'ticketCode',    // Actual column name in database (camelCase)
        'status',
        'payment_id',
        'isRefunded',    // Actual column name in database (camelCase)
    ];

    protected $casts = [
        'purchaseDate' => 'datetime',  // Match actual column name
        'isRefunded' => 'boolean',     // Match actual column name
    ];

    /**
     * Get the event associated with this ticket.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id'); // Updated to snake_case
    }

    /**
     * Get the user who purchased this ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Updated to snake_case
    }

    /**
     * Get the payment associated with this ticket.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id'); // Updated to snake_case
    }
}
