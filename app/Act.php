<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Act extends Model
{
    //
	
	use SoftDeletes;
	
	//protected $table = 'acts';
	
	protected $fillable = ['equipment_id', 'caller_id', 'caller_fio', 'user_act_accept', 'act_status', 'make_diagnos', 'need_spares', 'mistake', 'distance', 'delivery', 'problem', 'diagnos', 'plan', 'work', 'note', 'city', 'address', 'phone1, phone2', 'company', 'department'];
	
	public function equipment() 
	{
		return $this->belongsTo(Equipment::class);
	}

	public function caller() 
	{
		return $this->belongsTo(Person::class, 'caller_id');
	}

	public function user_act_accept() //кто создал заявку
	{
		return $this->belongsTo(User::class, 'user_act_accept');
	}
	
	public function users_act_diagnos() //кто ездил на диагностику
	{
		return $this->belongsToMany(User::class, 'users_act_diagnos');
	}
	
	public function users_act_close() //кто отремонтировал и закрыл заявку
	{
		return $this->belongsToMany(User::class, 'users_act_close');
	}

	public function files()
	{
		return $this->morphMany(StoreFile::class, 'owner'); //как называются столбцы ***_id и ***_type в промежуточной таблице
	}
}
