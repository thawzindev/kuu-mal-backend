<?php

namespace App\Filters;

class HelpRequestListFilter extends Filters
{

	/**
	 * Register filter properties
	 */
	protected $filters = [
		'state_id', 'township_id'
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

}