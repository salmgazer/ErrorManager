<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Error;
use App\BulkFile;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //errors submitted by user
    public function errors(){
        return $this->hasMany(Error::class);
    }

    //bulk files submitted by user
    public function bulkfiles(){
        return $this->hasMany(BulkFile::class);
    }

}
