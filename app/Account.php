<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //



/*
| ========================================================================================= 
| Account Model | Account - User Relationship | Many-To-Many | 
| =========================================================================================
*/

    public function users() {
        return $this->belongsToMany('App\User');
    }
}
