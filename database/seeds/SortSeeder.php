<?php

use App\Models\Applicant;
use App\Models\ApplicantGroup;
use App\Models\Company;
use Illuminate\Database\Seeder;

class SortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		foreach (ApplicantGroup::all() as $applicantGroup) {
			$sort = $applicantGroup->applicants->count();
			foreach ($applicantGroup->applicants()->orderBy('id', 'asc')->get() as $applicant) {
				$applicant->sort = $sort;
				$applicant->save();
				$sort--;
			}
		}

		$models = Company::all();
	    $sort = count($models);
		foreach ($models as $company) {
			$company->sort = $sort;
			$company->save();
			$sort--;
		}
    }
}
