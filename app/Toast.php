<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toast extends Model
{

    protected $guarded = [];


/*
| ========================================================================================= 
| Toast Model 
| =========================================================================================
*/
    // public function user() {
    //     return $this->belongsTo('App\User');
    // }

    public function message() {
        return $this->belongsTo('App\Message');
    }

    public function position() {
        return $this->belongsTo('App\Position');
    }

    // public function getPostImageAttribute($value) {
    //     if (strpos($value, 'https://') !== false || strpos($value, 'http://') !== false) {
    //         return $value;
    //     }
 
    //     return asset('storage/' . $value);
    // }

}
