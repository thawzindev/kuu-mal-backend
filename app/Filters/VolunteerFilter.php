<?php

namespace App\Filters;

class VolunteerFilter extends Filters
{

	/**
	 * Register filter properties
	 */
	protected $filters = [
		'state_id', 'township_id', 'keyword'
	];

	/**
	 * Filter by category.
	 */
	public function state_id($value) 
	{
		return $this->builder->where('state_id', $value);
	}
	
	public function township_id($value) 
	{
		return $this->builder->where('township_id', $value);
	}

	public function keyword($value) 
	{
		return $this->builder
			->where(function ($query) use ($value) {
				$query->where('name', 'LIKE', "%{$value}%")		
					  ->orWhere('phone', 'LIKE', "%{$value}%");
			});
	}

}