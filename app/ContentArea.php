<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentArea extends Model{
    protected $fillable = array('name', 'alias', 'order', 'description', 'createdBy');

    //D E F I N E  R E L A T I O N S H I P S
    //ContentArea is the child table to User, The FK is createdBy
    public function CreatedBy(){
        return $this->belongsTo('App\User', 'createdBy');
    }
}
