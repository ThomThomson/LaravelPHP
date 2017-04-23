<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModification extends Model{
    protected $fillable = array('modifiedBy', 'userModified');

    //D E F I N E  R E L A T I O N S H I P S
    //Page Modification is the child table to User, The FK is modifiedBy
    public function User(){
        return $this->belongsTo('App\User', 'modifiedBy');
    }
    //User Modification is the child table to user, The FK is articleModified
    public function CssTemplate(){
        return $this->belongsTo('App\User', 'userModified');
    }
}
