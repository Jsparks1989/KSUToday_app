<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

/*
| ========================================================================================= 
| Role Model | Role - User Relationship | One - To - Many | Role has many Users 
| =========================================================================================
*/
    public function users() {
        return $this->hasMany('App\User');
    }
















}
