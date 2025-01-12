<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Course extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Notifiable;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('worker_scope', function ($query) {
            if (auth()->check() && auth()->user()->hasRole('worker')) {
                $query->where('user_id', auth()->id());
            }
        });

        static::creating(function ($course) {
            if (empty($course->user_id)) {
                $course->user_id = Filament::auth()->id();
            }
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}