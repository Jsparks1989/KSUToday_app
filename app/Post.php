<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $guarded = [];


/*
| ========================================================================================= 
| Post Model | Post - User Relationship | Inverse | Post belongs to User
| =========================================================================================
*/
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function topic() {
        return $this->belongsTo('App\Topic');
    }

    public function getPostImageAttribute($value) {
        if (strpos($value, 'https://') !== false || strpos($value, 'http://') !== false) {
            return $value;
        }
 
        return asset('storage/' . $value);
    }

}
