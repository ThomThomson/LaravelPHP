<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CssTemplateModification extends Model{
    protected $fillable = array('modifiedBy', 'cssTemplateModified');

    //D E F I N E  R E L A T I O N S H I P S
    //CssTemplate Modification is the child table to User, The FK is modifiedBy
    public function User(){
        return $this->belongsTo('App\User', 'modifiedBy');
    }
    //CssTemplate Modification is the child table to CssTemplate, The FK is articleModified
    public function CssTemplate(){
        return $this->belongsTo('App\CssTemplate', 'cssTemplateModified');
    }
}
