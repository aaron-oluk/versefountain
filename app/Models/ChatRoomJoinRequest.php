<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomJoinRequest extends Model
{
        use HasFactory;

        protected $fillable = [
            'user_id',
            'chat_room_id',
            'status',
            'message',
            'reviewed_at',
            'reviewed_by',
        ];

        protected $casts = [
            'reviewed_at' => 'datetime',
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function chatRoom()
        {
            return $this->belongsTo(ChatRoom::class);
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
                'status' => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => $reviewerId,
            ]);
        }

        public function reject($reviewerId)
        {
            $this->update([
                'status' => 'rejected',
                'reviewed_at' => now(),
                'reviewed_by' => $reviewerId,
            ]);
        }
    //
}
