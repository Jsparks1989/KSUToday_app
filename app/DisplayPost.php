<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisplayPost extends Model
{
    //



/*
| ========================================================================================= 
| DisplayPost Model |  
| =========================================================================================
*/

    public function getNumDisplayed() {
        return $this->number_displayed;
    }
}
