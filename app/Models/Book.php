<?php
// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'coverImage',
        'uploadedById',
        'genre',
        'approved',
        'uuid',
    ];

    protected $casts = [
        'approved' => 'boolean',
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
     * Get the user who uploaded the book.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploadedById');
    }
}
