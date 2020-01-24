<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model

{
	use SoftDeletes;
	
	protected $fillable = ['name', 'surname', 'patronymic', 'phone1', 'phone2', 'post', 'executive', 'address', 'email', 'web'];

	public function companies()
	{
		return $this->morphedByMany(Company::class, 'relpeople');
	}

	public function departments()
	{
		return $this->morphedByMany(Department::class, 'relpeople');
	}
	
	public function files()
	{
		return $this->morphMany(StoreFile::class, 'storefiles');
	}
}
