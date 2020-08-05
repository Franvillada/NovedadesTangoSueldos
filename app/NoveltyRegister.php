<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoveltyRegister extends Model
{
    protected $dates = ['created_at', 'updated_at', 'date'];
    
    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function novelty(){
        return $this->belongsTo('App\Novelty');
    }
}
