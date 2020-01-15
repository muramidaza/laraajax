<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $fillable = ['name', 'director', 'phone1', 'phone2', 'address', 'website', 'email', 'OGRN', 'INN', 'KPP', 'UridAddr', 'OKPO', 'OKVED', 'RSchet', 'KSchet', 'BIK'];

	public function departments()
	{
		return $this->hasMany(Department::class);
	}
	
	public function people()
	{
		return $this->morphToMany(People::class, 'relpeople');
	}

}


