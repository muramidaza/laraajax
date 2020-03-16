<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
	use SoftDeletes;
	
	protected $fillable = ['name', 'director', 'phone1', 'phone2', 'city', 'address', 'website', 'email', 'contract', 'OGRN', 'INN', 'KPP', 'UridAddr', 'OKPO', 'OKVED', 'RSchet', 'KSchet', 'BIK'];

	public function departments()
	{
		return $this->hasMany(Department::class);
	}
	
	public function persons()
	{
		return $this->morphToMany(Person::class, 'relperson');
	}
	
	public function equipments()
	{
		return $this->morphMany(Equipment::class, 'owner');
	}

}


