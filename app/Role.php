<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['key'];

    public function acls() {
        return $this->hasMany('App\Role_Acl', 'role_id', 'id');
    }
    
    public function users () {
		return $this->hasMany('App\Role_User', 'role_id', 'id');
	}
    
    public function translates () {
    	return $this->hasMany('App\Role_Translate', 'role_id', 'id');
	}
}