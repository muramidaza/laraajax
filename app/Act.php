<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Act extends Model
{
    //
	
	use SoftDeletes;
	
	//protected $table = 'acts';
	
	protected $fillable = ['status', 'distance', 'delivery', 'problem', 'diagnos', 'plan', 'work', 'city', 'address', 'company', 'department', 'fio'];
	
	public function equipment() 
	{
		return $this->belongsTo(Equipment::class);
	}

	public function person() 
	{
		return $this->belongsTo(Person::class);
	}

	public function files()
	{
		return $this->morphMany(StoreFile::class, 'owner'); //как называются столбцы ***_id и ***_type в промежуточной таблице
	}
	
	public function user_who_accept() //кто создал заявку
	{
		return $this->belongsTo(User::class);
	}
	
	public function users_who_diagnos() //кто ездил на диагностику
	{
		return $this->belongsToMany(User::class, 'acts_users_diagnos');
	}
	
	public function users_who_close() //кто отремонтировал и закрыл заявку
	{
		return $this->belongsToMany(User::class, 'acts_users_close');
	}	
}
