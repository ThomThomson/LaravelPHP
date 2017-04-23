<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleModification extends Model{
    protected $fillable = array('modifiedBy', 'articleModified');

    //D E F I N E  R E L A T I O N S H I P S
    //Article Modification is the child table to User, The FK is modifiedBy
    public function User(){
        return $this->belongsTo('App\User', 'modifiedBy');
    }
    //Article Modification is the child table to Article, The FK is CssTemplateModified
    public function Article(){
        return $this->belongsTo('App\Article', 'cssTemplateModified');
    }
}


