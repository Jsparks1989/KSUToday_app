<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    protected $guarded = [];


/*
| ========================================================================================= 
| Position Model | Post - User Relationship | Inverse | Post belongs to User
| =========================================================================================
*/
    public function toast() {
        return $this->belongsTo('App\Toast');
    }

}
