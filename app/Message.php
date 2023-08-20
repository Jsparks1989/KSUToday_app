<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $guarded = [];


/*
| ========================================================================================= 
| Message Model | Message - Toast Relationship | Inverse | Message belongs to Toast
| =========================================================================================
*/
    public function toast() {
        return $this->belongsTo('App\Toast');
    }

    

}
