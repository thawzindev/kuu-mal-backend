<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpRequestList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo(\App\Models\State::class);
    }

    public function township()
    {
    	return $this->belongsTo(\App\Models\Township::class);
    }

    public function isComplete()
    {
        return $this->status == 0 ? 'Not Complete' : 'Completed';
    }

    public function isCompleteButton()
    {
        return $this->status == 1 ? 'Not Complete' : 'Completed';
    }

    public function scopeActive($query){
        return $query->where('status', 0);
    }

    public function label() 
    {
        if ($this->status == 1) return 'success';
        if ($this->status == 0) return 'danger';
    }

    public function buttonLabel() 
    {
        if ($this->status == 1) return 'warning';
        if ($this->status == 0) return 'success';
    }

    public function scopeFilter($query, $filter)
    {
        $filter->apply($query);
    }
}
