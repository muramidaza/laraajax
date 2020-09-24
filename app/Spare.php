<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
    //
	protected $fillable = ['type', 'name', 'model', 'parameter', 'qty', 'unit', 'note', 'ordered', 'datedeliv', 'servicedeliv', 'instock', 'installed'];

	public function act() 
	{
		return $this->belongsTo(Act::class, 'act_id');
	}	
}
