<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
// class User extends Model implements Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    



/*
| ========================================================================================= 
| User Model | User - Post Relationship | One - To - One | User has one Post
| =========================================================================================
*/
    public function post() {
        return $this->hasOne('App\Post');
    }




/*
| ========================================================================================= 
| User Model | User - Post Relationship | One - To - Many | User has many Posts
| =========================================================================================
*/
    public function posts() {
        return $this->hasMany('App\Post');
    }






/*
| ========================================================================================= 
| User Model | User - Role Relationship | Inverse | User belongs to Role
| =========================================================================================
*/
    public function role() {
        return $this->belongsTo('App\Role');
    }




/*
| ========================================================================================= 
| User Model | User - Account Relationship | Many-To-Many | 
| =========================================================================================
*/


    public function accounts() {
        return $this->belongsToMany('App\Account');
    }







/**
 * ========================================================================================= 
 * Methods interacting with user's role
 * =========================================================================================
 */


    public function isUser() {
        if($this->role->name == 'user'){
            return true;
        } else {
            return false;
        }
    }


    public function isContributor() {
        if($this->role->name == 'contributor'){
            return true;
        } else {
            return false;
        }
    }


    public function isModerator() {
        if($this->role->name == 'moderator'){
            return true;
        } else {
            return false;
        }
    }


    public function isAdmin() {
        if($this->role->name == 'admin'){
            return true;
        } else {
            return false;
        }
    }



    public function isInactive() {
        if($this->role->name == 'inactive'){
            return true;
        } else {
            return false;
        }
    }


}
