<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'address', 'website', 'email'];
	
/* 	public function departments()
   {
     return $this->hasMany(Department::class);
   } */

}
