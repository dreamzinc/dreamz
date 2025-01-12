<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded = [];

    protected $casts = [
        'status' => 'string',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PROGRESS = 'progress';
    const STATUS_CANCEL = 'cancel';
    const STATUS_DONE = 'done';

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('promotion_scope', function ($query) {
            if (auth()->check() && auth()->user()->hasRole('promotion')) {
                $userPromotion = Promotion::where('user_id', auth()->id())->first();
                $refferalCode = $userPromotion?->code;
                if ($refferalCode) {
                    $query->where('referral_code', $refferalCode);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        });

        static::addGlobalScope('worker_scope', function ($query) {
            if (auth()->check() && auth()->user()->hasRole('worker')) {
                $userService = Service::where('user_id', auth()->id())->pluck('id');
                $userCourse = Course::where('user_id', auth()->id())->pluck('id');

                $query->where(function ($query) use ($userService, $userCourse) {
                    $query->whereIn('service_id', $userService)
                        ->orWhereIn('course_id', $userCourse);
                });
            }
        });

        static::creating(function ($order) {
            if (!$order->order_code) {
                do {
                    $randomNumber = rand(1000, 9999);
                    $order->order_code = 'DZ-' . $randomNumber;
                } while (self::where('order_code', $order->order_code)->exists());
            }
        });
    }

    public static function statusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROGRESS => 'Progress',
            self::STATUS_CANCEL => 'Cancel',
            self::STATUS_DONE => 'Done',
        ];
    }
}
