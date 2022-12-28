<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['key'];

    public function acls() {
        return $this->hasMany('App\Models\Role_Acl', 'role_id', 'id');
    }
    
    public function users () {
		return $this->hasMany('App\Models\Role_User', 'role_id', 'id');
	}
    
    public function translates () {
    	return $this->hasMany('App\Models\Role_Translate', 'role_id', 'id');
	}
}