<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApplicantCompany extends Model
{
	protected $table = 'applicant_companies';

	protected $primaryKey = ['applicant_id', 'job_position_id'];

	protected $fillable = ['applicant_id', 'job_position_id', 'status', 'send_date'];

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
		return array_map(function ($value, $title) use ($selected) {
			return [
				'value' => $value,
				'title' => $title,
				'selected' => (bool) $value === $selected,
			];
		}, [
			1 => trans('Átküldve'),
			2 => trans('Elutasítva (sokat kér)'),
			3 => trans('Elutasítva (kevés tapasztalat)'),
			4 => trans('Időközben elhelyezkedett'),
			5 => trans('Ajánlatot kapott, nem fogadta el'),
			6 => trans('Interjú'),
			7 => trans('2. Interjú'),
			8 => trans('Ajánlattétel'),
			9 => trans('Elhelyezve'),
		]);

		/*return [
			1 => ['value' => 1, 'title' => trans('Átküldve'), 'selected' => (bool) ($selected === 1)],
			2 => ['value' => 2, 'title' => trans('Elutasítva (sokat kér)'), 'selected' => (bool) ($selected === 2)],
			3 => ['value' => 3, 'title' => trans('Elutasítva (kevés tapasztalat)'), 'selected' => (bool) ($selected === 3)],
			4 => ['value' => 4, 'title' => trans('Időközben elhelyezkedett'), 'selected' => (bool) ($selected === 4)],
			5 => ['value' => 5, 'title' => trans('Ajánlatot kapott, nem fogadta el'), 'selected' => (bool) ($selected === 5)],
			6 => ['value' => 6, 'title' => trans('Interjú'), 'selected' => (bool) ($selected === 6)],
			7 => ['value' => 7, 'title' => trans('2. Interjú'), 'selected' => (bool) ($selected === 7)],
			8 => ['value' => 8, 'title' => trans('Ajánlattétel'), 'selected' => (bool) ($selected === 8)],
			9 => ['value' => 9, 'title' => trans('Elhelyezve'), 'selected' => (bool) ($selected === 9)],
		];*/
	}
}
