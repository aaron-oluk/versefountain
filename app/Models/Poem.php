<?php
// app/Models/Poem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Poem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author_id', // Updated to snake_case
        'is_video',  // Updated to snake_case
        'video_url', // Updated to snake_case
        'approved',
        'uuid',
    ];

    protected $casts = [
        'is_video' => 'boolean',  // Updated to snake_case
        'approved' => 'boolean',
        'created_at' => 'datetime', // Laravel's default
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
     * Get the author of the poem.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id'); // Updated to snake_case
    }

    /**
     * Get the user (alias for author) of the poem.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the user interactions (likes and ratings) for the poem.
     */
    public function userInteractions()
    {
        return $this->hasMany(UserPoem::class, 'poem_id');
    }

    /**
     * Get the comments for the poem.
     */
    public function comments()
    {
        return $this->hasMany(PoemComment::class, 'poem_id'); // Updated to snake_case
    }
}
