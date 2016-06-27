<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Error extends Model
{
    //
    //get user wh submitted this error
    public function user(){
    	return $this->belongsTo(User::class);
    }

}
