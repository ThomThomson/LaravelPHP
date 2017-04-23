<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageModification extends Model{
    protected $fillable = array('modifiedBy', 'pageModified');

    //D E F I N E  R E L A T I O N S H I P S
    //Page Modification is the child table to User, The FK is modifiedBy
    public function User(){
        return $this->belongsTo('App\User', 'modifiedBy');
    }
    //Page Modification is the child table to CssTemplate, The FK is articleModified
    public function CssTemplate(){
        return $this->belongsTo('App\Page', 'pageModified');
    }
}
