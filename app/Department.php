<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
	protected $fillable = ['name', 'address', 'website', 'email'];
	
	public function company() {
		return $this->belongsTo(Company::class);
	}
}
