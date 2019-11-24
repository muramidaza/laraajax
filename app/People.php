<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model

{
	protected $fillable = ['name', 'surname', 'patronymic', 'phone1', 'phone2', 'job', 'address', 'email'];

	public function companies()
	{
		return $this->morphedByMany(Company::class, 'relPeople');
	}

	public function departments()
	{
		return $this->morphedByMany(Department::class, 'relPeople');
	}
}
