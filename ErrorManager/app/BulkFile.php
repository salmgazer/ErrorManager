<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\BulkFile;

class BulkFile extends Model
{
    //
	//get user who submitted bulk file
    public function user(){
    	return $this->belongsTo(User::class);
    }

    //get errors
    public function errors(){
    	return $this->hasMany(Error::class);
    }

}
