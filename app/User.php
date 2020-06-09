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
	
	public function accept_akts() //принятые заявки
	{
		return $this->hasMany(Akt::class);
	}

	public function diagnos_akts() //продиагностированные заявки
	{
		return $this->belongsToMany(Akt::class, 'akts_users_diagnos');
	}
	
	public function close_akts() //закрытые заявки
	{
		return $this->belongsToMany(Akt::class, 'akts_users_close');
	}	
	
}
