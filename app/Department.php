<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    //
	use SoftDeletes;
	
	protected $fillable = ['name', 'manager', 'phone1', 'phone2', 'address', 'company_id'];
	
	public function company() 
	{
		return $this->belongsTo(Company::class);
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
