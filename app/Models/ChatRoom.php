<?php
// app/Models/ChatRoom.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by_id', // Updated to snake_case
        'is_private',    // Updated to snake_case
    ];

    protected $casts = [
        'is_private' => 'boolean', // Updated to snake_case
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Get the user who created the chat room.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id'); // Updated to snake_case
    }

    /**
     * Get the messages in this chat room.
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'room_id'); // Updated to snake_case
    }

    /**
     * Get the users who are members of this chat room.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'user_chat_rooms', 'room_id', 'user_id');
    }

    /**
     * Get pending invitations for this chat room.
     */
    public function invitations()
    {
        return $this->hasMany(ChatRoomInvitation::class, 'room_id')->where('type', 'invitation');
    }

    /**
     * Get pending access requests for this chat room.
     */
    public function accessRequests()
    {
        return $this->hasMany(ChatRoomInvitation::class, 'room_id')->where('type', 'request');
    }

    /**
     * Get all invitations and requests for this chat room.
     */
    public function allInvitations()
    {
        return $this->hasMany(ChatRoomInvitation::class, 'room_id');
    }
}
