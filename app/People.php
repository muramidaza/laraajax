<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class people extends Model
{

   public function companies()
   {
     return $this->morphedByMany(Companies::class, 'relPeople');
   }
 
   public function departments()
   {
     return $this->morphedByMany(Departments::class, 'relPeople');
   }
}
