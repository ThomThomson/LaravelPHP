<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'password', 'createdBy'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getIsAdminAttribute()
    {
        return count(UsersToAccessLevel::where(['userID' => $this->id, 'accesslevelID' => 1])->get()) > 0;
    }

    public function getIsEditorAttribute()
    {
        return count(UsersToAccessLevel::where(['userID' => $this->id, 'accesslevelID' => 2])->get()) > 0;
    }

    public function getIsAuthorAttribute()
    {
        return count(UsersToAccessLevel::where(['userID' => $this->id, 'accesslevelID' => 3])->get()) > 0;
    }
}
