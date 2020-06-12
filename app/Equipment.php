<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    //
	use SoftDeletes;
	
	protected $table = 'equipments';
	
	protected $fillable = ['type', 'manufacturer', 'model', 'modification', 'sernumber', 'datemanuf', 'invnumber', 'voltage', 'current', 'power', 'weight', 'sizes', 'note', 'incontract'];
	
	public function owner()
	{
		return $this->morphTo();
	}
	
	public function files()
	{
		return $this->morphMany(StoreFile::class, 'owner'); //как называются столбцы ***_id и ***_type в промежуточной таблице
	}
	
	public function acts()
	{
		return $this->hasMany(Act::class);
	}	
}
