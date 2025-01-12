<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
