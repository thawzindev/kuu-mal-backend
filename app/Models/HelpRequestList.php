<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpRequestList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function township()
    {
    	return $this->belongsTo(\App\Models\Township::class);
    }

    public function scopeNotComplete($query){
        return $query->where('status', 0);
    }

}
