<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model

{
	protected $fillable = ['name', 'address'];

	public function companies()
	{
		return $this->morphedByMany(Company::class, 'relPeople');
	}

	public function departments()
	{
		return $this->morphedByMany(Department::class, 'relPeople');
	}
}
