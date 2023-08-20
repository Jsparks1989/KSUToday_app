<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    public function category() {
        return $this->belongsTo('App\Category');
    }


    public function post() {
        return $this->hasMany('App\Post');
    }
}
