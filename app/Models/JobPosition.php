<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

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
 * @property string $contact_email_2
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

	protected $fillable = ['company_id', 'title', 'description', 'contact_name', 'contact_email', 'contact_email_2', 'contact_phone', 'is_active'];

	protected $casts = ['is_active' => 'boolean'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	/**
     * Relations of applicants
     *
	 * @return BelongsToMany
	 */
	public function applicants(): BelongsToMany
    {
		return $this->belongsToMany( Applicant::class );
	}

	/**
     * Relations of skills
     *
	 * @return BelongsToMany
	 */
	public function skills(): BelongsToMany
    {
		return $this->belongsToMany( Skill::class );
	}

	/**
     * Relation of company
     *
	 * @return HasOne
	 */
	public function company(): HasOne
    {
		return $this->hasOne(Company::class, 'id', 'company_id');
	}

	/**
     * Relations of users
     *
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany
    {
		return $this->belongsToMany(User::class);
	}

	/**
     * Implementation of validation rules
     *
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
            'contact_email_2' => [
                'nullable',
                'email',
            ],
			'contact_phone' => [
				'required',
				'regex:' . config('app.input_formats.phone_number'),
			],
			'is_active' => [
				'boolean',
			],
		];
	}

	/**
     * Implementation of validation nice names
     *
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'title' => trans('Megnevezés'),
			'description' => trans('Leírás'),
			'contact_name' => trans('Kapcsolattartó név'),
			'contact_email' => trans('Kapcsolattartó email'),
            'contact_email_2' => trans('További kapcsolattartó email'),
			'contact_phone' => trans('Kapcsolattartó telefon'),
		];
	}

	/**
	 * @param int $company_id
	 * @return array|array[]
	 */
	public static function getDropdownItems(int $company_id): array
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
	 * @return JobPosition[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
	 */
	public static function getCompanyDropdownItems(bool $onlyActive = true)
	{
		$models = static::with('company')
			->where(function ($q) use($onlyActive) {
				if ($onlyActive) {
					$q->where('is_active', 1);
				}
			})
			->orderBy('title', 'asc')
			->get();

		return $models->sortBy(function ($item) {
			return $item->company->name . ' - ' . $item->title;
		}, SORT_REGULAR, false);
	}

	/**
     * Implement isDeletable method
     *
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		return (bool) !$this->applicants()->count();
	}

	/**
     * Override delete method
     *
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

	/**
     * Implement of validation custom messages
     *
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [];
	}
}
