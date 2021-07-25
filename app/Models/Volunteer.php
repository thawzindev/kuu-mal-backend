<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Volunteer as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Volunteer extends Model
{
    use HasFactory,HasApiTokens;

    protected $guarded = [];

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function township()
    {
    	return $this->belongsTo(\App\Models\Township::class);
    }
}
