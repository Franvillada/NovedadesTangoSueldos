<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{   
    protected $fillable = ['client_id','name','employee_number','entry_date','vacations','scoring'];
    public function client(){
        return $this->belongsTo('App\Client');
    }
    
    public function noveltyRegister(){
        return $this->hasMany('App\NoveltyRegister');
    } 
}
