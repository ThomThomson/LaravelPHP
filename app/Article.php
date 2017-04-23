<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model{
    protected $fillable = array('name', 'title', 'description',
        'page', 'allPages','contentArea', 'htmlContent', 'createdBy');

    //D E F I N E  R E L A T I O N S H I P S
    //Article is the child table to Page, The FK is page
    public function Page(){
        return $this->belongsTo('App\Page', 'page');
    }
    //Article is the child table to ContentArea, The FK is contentArea
    public function ContentArea(){
        return $this->belongsTo('App\ContentArea', 'contentArea');
    }
    //Article is the child table to User, The FK is createdBy
    public function CreatedBy(){
        return $this->belongsTo('App\User', 'createdBy');
    }
}
