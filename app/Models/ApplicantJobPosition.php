<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApplicantJobPosition extends Model
{
	protected $table = 'applicant_job_position';

	/**
	 * @return HasOne
	 */
	public function applicant()
	{
		return $this->hasOne(Applicant::class);
	}

	/**
	 * @return HasOne
	 */
	public function job_position()
	{
		return $this->hasOne(JobPosition::class);
	}
}
