<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApplicantJobPosition extends Model
{
	protected $table = 'applicant_job_position';
	protected $fillable = ['applicant_id', 'job_position_id', 'description', 'send_date', 'monogram'];

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
}
