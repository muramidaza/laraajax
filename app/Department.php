<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
	protected $fillable = ['name', 'address', 'company_id'];
	
	public function company() 
	{
		return $this->belongsTo(Company::class);
	}
	
	public function people()
	{
		return $this->morphToMany(People::class, 'relpeople');
	}
}
