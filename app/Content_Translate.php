<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content_Translate extends Model
{
	protected $table = 'content_translates';
	
	protected $fillable = ['slug', 'meta_title', 'meta_description', 'meta_keywords', 'lead', 'body', 'active'];
}
