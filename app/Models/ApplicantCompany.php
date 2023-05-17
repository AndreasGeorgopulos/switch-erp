<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ApplicantCompany extends Model
{
	protected $table = 'applicant_companies';

	protected $primaryKey = ['applicant_id', 'job_position_id'];

	public $incrementing = false;

	protected $fillable = ['applicant_id', 'job_position_id', 'status', 'send_date', 'information', 'interview_time', 'salary', 'work_begin_date', 'follow_up', 'monogram'];

	public function save(array $options = [])
	{
		$this->salary = str_replace('.', '', $this->salary);
		return parent::save($options);
	}

	/**
	 * @return HasOne
	 */
	public function applicant()
	{
		return $this->hasOne(Applicant::class, 'id', 'applicant_id');
	}

	/**
	 * @return HasOne
	 */
	public function job_position()
	{
		return $this->hasOne(JobPosition::class, 'id', 'job_position_id');
	}

	/**
	 * @param $selected
	 * @return array|array[]
	 */
	public static function getStatusDropdownItems($selected = 1)
	{
		return [
			1 => ['value' => 1, 'title' => trans('Átküldve'), 'selected' => (bool) ($selected === 1)],
			2 => ['value' => 2, 'title' => trans('Elutasítva'), 'selected' => (bool) ($selected === 2)],
			3 => ['value' => 3, 'title' => trans('Időközben elhelyezkedett'), 'selected' => (bool) ($selected === 3)],
			4 => ['value' => 4, 'title' => trans('Interjú'), 'selected' => (bool) ($selected === 4)],
			5 => ['value' => 5, 'title' => trans('2. Interjú'), 'selected' => (bool) ($selected === 5)],
			6 => ['value' => 6, 'title' => trans('Ajánlatot kapott'), 'selected' => (bool) ($selected === 6)],
			7 => ['value' => 7, 'title' => trans('Elhelyezve'), 'selected' => (bool) ($selected === 7)],
			8 => ['value' => 8, 'title' => trans('Visszalépett'), 'selected' => (bool) ($selected === 8)],
		];
	}

	/**
	 * @return Collection
	 */
	public static function getCompanies()
	{
		$authJobPositionIds = Auth::user()->job_positions()->where('is_active', true)->pluck('id')->toArray();
		$companies = [];
		$models = !hasRole('superadministrator') && count($authJobPositionIds) ? static::whereIn('job_position_id', $authJobPositionIds)->get() : static::all();

		foreach ($models as $model) {
			$companyModel = $model->job_position->company;
			if (isset($companies[$companyModel->id]) || !$companyModel->is_active) {
				continue;
			}
			$companies[$companyModel->id] = $companyModel;
		}

		return collect($companies)->sortBy('name', SORT_REGULAR, false);
	}

	/**
	 * @param $company_id
	 * @return Collection
	 */
	public static function getJobPositions($company_id)
	{
		$authJobPositionIds = Auth::user()->job_positions()->where('is_active', true)->pluck('id')->toArray();
		$job_positions = [];
		$companies = [];
		$models = !hasRole('superadministrator') && count($authJobPositionIds) ? static::whereIn('job_position_id', $authJobPositionIds)->get() : static::all();

		foreach ($models as $model) {
			$companyModel = $model->job_position->company;
			if ($companyModel->id != $company_id || !$companyModel->is_active || isset($job_positions[$model->job_position->id])) {
				continue;
			}

			$job_positions[$model->job_position->id] = $model->job_position;
		}

		return collect($job_positions)->sortBy('name', SORT_REGULAR, false);
	}

	/**
	 * @param $job_position_id
	 * @return Collection
	 */
	public static function getSearchModels($job_position_id)
	{
		return collect(static::where('job_position_id', $job_position_id)->get())->sortBy(function ($item) {
			if (in_array($item->status, [1, 4, 5])) {
				return $item->applicant->name;
			}
			return $item->applicant->last_contact_date;
		}, SORT_REGULAR, false);
	}

	/**
	 * @return Collection
	 */
	public static function getWorkModels()
	{
		return collect(static::where('status', 7)->orderBy('work_begin_date', 'asc')->get());
	}

	/**
	 * @param int|null $job_position_id
	 * @return array
	 */
	public static function getCouters($job_position_id = null)
	{
		$result = [];
		foreach (['all', 'active', 'inactive', 'ready'] as $key) {
			$result[$key] = static::where(function ($q) use($job_position_id, $key) {
				if ($key === 'all') {
					$q->where('status', '>=', 1);
				} elseif ($key === 'active') {
					$q->whereNotIn('status', [2, 3, 7]);
				} elseif ($key === 'inactive') {
					$q->whereIn('status', [2, 3]);
				} elseif ($key === 'ready') {
					$q->whereIn('status', [7]);
				}

				if ($job_position_id !== null) {
					$q->where('job_position_id', $job_position_id);
				}
			})->count();
		}

		return $result;
	}

	/**
	 * Set the keys for a save update query.
	 *
	 * @param  Builder  $query
	 * @return Builder
	 */
	protected function setKeysForSaveQuery(Builder $query)
	{
		$keys = $this->getKeyName();
		if(!is_array($keys)){
			return parent::setKeysForSaveQuery($query);
		}

		foreach($keys as $keyName){
			$query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
		}

		return $query;
	}

	/**
	 * Get the primary key value for a save query.
	 *
	 * @param mixed $keyName
	 * @return mixed
	 */
	protected function getKeyForSaveQuery($keyName = null)
	{
		if(is_null($keyName)){
			$keyName = $this->getKeyName();
		}

		if (isset($this->original[$keyName])) {
			return $this->original[$keyName];
		}

		return $this->getAttribute($keyName);
	}
}
