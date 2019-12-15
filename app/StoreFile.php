<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreFile extends Model
{
	public function owner()
	{
		return $this->morphTo();
	}
}
