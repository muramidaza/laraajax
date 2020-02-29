<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    //
	use SoftDeletes;
	
	protected $fillable = ['type', 'manufacturer', 'model', 'modification', 'sernumber', 'datemanuf', 'invnumber', 'voltage', 'current', 'power', 'weight', 'sizes', 'note', 'incontract'];
	
	public function owner()
	{
		return $this->morphTo();
	}
}
