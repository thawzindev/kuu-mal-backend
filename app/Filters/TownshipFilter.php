<?php

namespace App\Filters;

class TownshipFilter extends Filters
{

	/**
	 * Register filter properties
	 */
	protected $filters = [
		'state_id'
	];

	/**
	 * Filter by category.
	 */
	public function state_id($value) 
	{
		return $this->builder->where('state_id', $value);
	}

}