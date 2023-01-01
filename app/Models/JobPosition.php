<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Job position model
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-27
 *
 * @property int $id
 * @property int $company_id
 * @property string $title
 * @property string $description
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_phone
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class JobPosition extends Model implements IModelRules
{
	use SoftDeletes;

	protected $table = 'job_positions';

	protected $fillable = ['company_id', 'title', 'description', 'contact_name', 'contact_email', 'contact_phone', 'is_active'];

	protected $casts = ['is_active' => 'boolean'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * @return BelongsToMany
	 */
	public function skills()
	{
		return $this->belongsToMany( Skill::class );
	}

	/**
	 * @return HasOne
	 */
	public function company()
	{
		return $this->hasOne(Company::class);
	}

	/**
	 * @return array
	 */
	public static function rules()
	{
		return [];
	}

	/**
	 * @return array
	 */
	public static function niceNames()
	{
		return [];
	}
}
