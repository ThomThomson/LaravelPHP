<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersToAccessLevel extends Model{
    protected $fillable = array('userID', 'accesslevelID');

    //D E F I N E  R E L A T I O N S H I P S
    //UserToAccessLevel is the child table to User, The FK is page
    public function User(){
        return $this->belongsTo('App\User', 'userID');
    }
    //UserToAccessLevel is the child table to AccessLevel, The FK is page
    public function AccessLevel(){
        return $this->belongsTo('App\AccessLevel', 'accesslevelID');
    }
}
