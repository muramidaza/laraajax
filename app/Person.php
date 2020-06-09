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
		return $this->morphedByMany(Company::class, 'relperson'); // Laravel пересирает person в people, как будто Лицо во множественном числе - Люди, хотя в английском persons, так и есть - лица поэтому таблица relpeople
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
	
	public function akts()
	{
		return $this->hasMany(Akt::class);
	}	
	
}
