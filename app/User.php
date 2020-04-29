<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{  
    use AuthenticableTrait;
    public function client(){
        return $this->belongsTo('App\Client');
    }

    public function role(){       
        return $this->belongsTo('App\Role');
    }
}
