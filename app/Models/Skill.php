<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Skill management model
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Skill extends Model implements IModelRules
{
	use SoftDeletes;
	protected $table = 'skills';
	protected $fillable = [
		'name',
		'is_active'
	];

	/**
	 * @return BelongsToMany
	 */
	public function applicants()
	{
		return $this->belongsToMany(Applicant::class);
	}

	/**
	 * @return array
	 */
	public static function rules()
	{
		return [
			'name' => [
				'required',
				'max:255',
			],
		];
	}

	/**
	 * @return array
	 */
	public static function niceNames()
	{
		return [
			'name' => trans( 'Név' ),
		];
	}
}
