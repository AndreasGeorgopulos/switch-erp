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
class JobPosition extends Model implements IModelRules, IModelDeletable
{
	use SoftDeletes;

	protected $table = 'job_positions';

	protected $fillable = ['company_id', 'title', 'description', 'contact_name', 'contact_email', 'contact_phone', 'is_active'];

	protected $casts = ['is_active' => 'boolean'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * @return BelongsToMany
	 */
	public function applicants()
	{
		return $this->belongsToMany( Applicant::class );
	}

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
		return $this->hasOne(Company::class, 'id', 'company_id');
	}

	/**
	 * @return array
	 */
	public static function rules(): array
	{
		return [
			'title' => [
				'required',
				'max:255',
			],
			'description' => [
				'required',
			],
			'contact_name' => [
				'required',
				'max:255',
			],
			'contact_email' => [
				'required',
				'email',
			],
			'contact_phone' => [
				'required',
				'max:255',
			],
			'is_active' => [
				'boolean',
			],
		];
	}

	/**
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'title' => trans('Megnevezés'),
			'description' => trans('Leírás'),
			'contact_name' => trans('Kapcsolattartó név'),
			'contact_email' => trans('Kapcsolattartó email'),
			'contact_phone' => trans('Kapcsolattartó telefon'),
		];
	}

	/**
	 * @param int $company_id
	 * @return array|array[]
	 */
	public static function getDropdownItems($company_id)
	{
		$models = static::select(['id', 'title'])
			->where(function ($q) use($company_id) {
				$q->where('is_active', 1);
				$q->where('company_id', $company_id);
			})
			->get()
			->toArray();


		return array_map(function ($item) {
			return [
				'value' => $item['id'],
				'title' => $item['title'],
			];
		}, $models);
	}

	/**
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		return (bool) !$this->applicants()->count();
	}

	/**
	 * @return bool|null
	 * @throws Exception
	 */
	public function delete(): ?bool
	{
		if (!$this->isDeletable()) {
			return false;
		}
		return parent::delete();
	}
}
