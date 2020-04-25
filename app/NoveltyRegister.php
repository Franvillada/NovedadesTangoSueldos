<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoveltyRegister extends Model
{
    public function file(){
        return $this->belognsTo('App\File');
    }
}
