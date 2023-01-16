<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['key'];

    public function acls(): HasMany
    {
        return $this->hasMany('App\Models\Role_Acl', 'role_id', 'id');
    }
    
    public function users (): HasMany
    {
		return $this->hasMany('App\Models\Role_User', 'role_id', 'id');
	}
    
    public function translates (): HasMany
    {
    	return $this->hasMany('App\Models\Role_Translate', 'role_id', 'id');
	}
}