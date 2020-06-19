<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
	use SoftDeletes;
	
	protected $fillable = ['name', 'realname', 'surname', 'patronymic', 'datebirth', 'sex', 'phone1', 'phone2', 'post', 'executive', 'address', 'rules', 'email', 'web', 'password'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function files()
	{
		return $this->morphMany(StoreFile::class, 'owner'); //как называются столбцы ***_id и ***_type в промежуточной таблице
	}
	
	public function accept_acts() //принятые заявки
	{
		return $this->hasMany(Act::class, 'user_act_accept');
	}

	public function diagnos_acts() //продиагностированные заявки
	{
		return $this->belongsToMany(Act::class, 'users_act_diagnos');
	}
	
	public function close_acts() //закрытые заявки
	{
		return $this->belongsToMany(Act::class, 'users_act_close');
	}	
	
}
