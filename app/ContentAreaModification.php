<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentAreaModification extends Model{
    protected $fillable = array('modifiedBy', 'contentAreaModified');

    //D E F I N E  R E L A T I O N S H I P S
    //ContentArea Modification is the child table to User, The FK is modifiedBy
    public function User(){
        return $this->belongsTo('App\User', 'modifiedBy');
    }
    //ContentArea Modification is the child table to ContentArea, The FK is articleModified
    public function ContentArea(){
        return $this->belongsTo('App\ContentArea', 'contentAreaModified');
    }
}
