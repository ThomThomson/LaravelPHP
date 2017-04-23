<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CssTemplate extends Model{
    protected $fillable = array('name', 'active', 'cssContent', 'createdBy');

    public function CreatedBy(){
        return $this->belongsTo('App\User', 'createdBy');
    }
}
