<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function client(){
        return $this->belongsTo('App\Client');
    }
    
    public function noveltyRegister(){
        return $this->hasMany('App\NoveltyRegister');
    } 
}
