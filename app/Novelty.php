<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novelty extends Model
{
    public function noveltyRegister(){
        return $this->hasMany('App\NoveltyRegister');
    } 
}
