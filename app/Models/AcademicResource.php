<?php
// app/Models/AcademicResource.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AcademicResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'subject',
        'grade_level',
        'language',
        'resource_url',
        'uuid',
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
}
