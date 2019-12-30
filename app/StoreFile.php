<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storefile extends Model
{
	public function owner()
	{
		return $this->morphTo();
	}
}
