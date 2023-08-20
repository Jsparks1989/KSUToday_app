<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DigestEmail extends Model
{
    //



/*
| ========================================================================================= 
| DigestEmail Model |  DigestEmail belongs to CronJobDigest
| =========================================================================================
*/

    public function cronJobDigest() {
        return $this->belongsTo('App\CronJobDigest');
    }
}
