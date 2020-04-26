<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function user(){
        return $this->hasMany('App\User');
    }

    public function employee(){
        return $this->hasMany('App\Employee');
    }
}
