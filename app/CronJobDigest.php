<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronJobDigest extends Model
{
    //



/*
| ========================================================================================= 
| DigestEmail Model |  One - To - One | CronJobDigest has one DigestEmail
| =========================================================================================
*/

    public function digestEmail() {
        return $this->hasOne('App\DigestEmail');
    }
}
