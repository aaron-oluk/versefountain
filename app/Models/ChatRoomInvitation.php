<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'invited_by',
        'type',
        'status',
        'message',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInvitations($query)
    {
        return $query->where('type', 'invitation');
    }

    public function scopeRequests($query)
    {
        return $query->where('type', 'request');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function approve($reviewerId)
    {
        $this->update([
            'status' => 'accepted',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
        ]);
    }

    public function decline($reviewerId)
    {
        $this->update([
            'status' => 'declined',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
        ]);
    }
}
