<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Promotion extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('promotion_scope', function ($query) {
            if (auth()->check() && auth()->user()->hasRole('promotion')) {
                $query->where('user_id', auth()->id());
            }
        });

        static::creating(function ($promotion) {
            if (empty($promotion->user_id)) {
                $promotion->user_id = Filament::auth()->id();
            }
        });

        static::creating(function ($promotion) {
            $promotion->code = Str::uuid()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
