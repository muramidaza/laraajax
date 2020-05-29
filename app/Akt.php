<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akt extends Model
{
    //
	
	use SoftDeletes;
	
	//protected $table = 'akts';
	
	protected $fillable = [];	
}
