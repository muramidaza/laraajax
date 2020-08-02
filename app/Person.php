<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model

{
	use SoftDeletes;
	
	protected $table = 'persons';
	
	protected $fillable = ['name', 'surname', 'patronymic', 'datebirth', 'sex', 'phone1', 'phone2', 'post', 'executive', 'address', 'email', 'web'];

	public function companies()
	{
		return $this->morphedByMany(Company::class, 'relperson');
	}

	public function departments()
	{
		return $this->morphedByMany(Department::class, 'relperson');
	}
	
	public function files()
	{
		return $this->morphMany(StoreFile::class, 'owner'); //как называются столбцы ***_id и ***_type в промежуточной таблице
	}
	
	public function equipments()
	{
		return $this->morphMany(Equipment::class, 'owner');
	}
	
	public function maked_calls()
	{
		return $this->hasMany(Act::class);
	}
	
	public function acts()
	{
		return $this->morphMany(Act::class, 'owner');
	}	
	
}
