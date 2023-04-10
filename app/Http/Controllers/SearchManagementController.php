<?php

namespace App\Http\Controllers;

use App\Models\ApplicantCompany;
use App\Models\Company;
use App\Models\JobPosition;
use Exception;
use Illuminate\Http\Request;

class SearchManagementController extends Controller
{
    public function index($company = null, $job = null)
    {
		$companies = ApplicantCompany::getCompanies();
		$selectedCompany = $company !== null ? Company::where('id', $company)->first() : null;
		$selectedJobPosition = $job !== null ? JobPosition::where('id', $job)->first() : null;
	    $job_positions = $selectedCompany !== null ? ApplicantCompany::getJobPositions($selectedCompany->id) : null;
		$models = !empty($selectedJobPosition) ? ApplicantCompany::getSearchModels($selectedJobPosition->id) : null;

	    return view('search_management.index', [
		    'site_title' => trans('Pozíciók'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'models' => $models,
		    'companies' => $companies,
		    'job_positions' => $job_positions,
		    'selectedCompany' => $selectedCompany,
		    'selectedJobPosition' => $selectedJobPosition,
	    ]);
    }

	public function saveData(Request $request)
	{
		try {
			$model = ApplicantCompany::where(function ($q) use($request) {
				$q->where('applicant_id', $request->get('applicant_id'));
				$q->where('job_position_id', $request->get('job_position_id'));
			})->first();

			if (empty($model)) {
				throw new Exception('Model not found');
			}

			$updateFields = [];
			foreach(['status', 'information', 'interview_time', 'send_date'] as $field) {
				if ($field === 'send_date' && empty($request->get($field))) {
					continue;
				}
				$updateFields[$field] = $request->get($field);
			}

			$model->update($updateFields);

			$model->applicant->update([
				'last_contact_date' => $request->get('last_contact_date'),
			]);

			return response()->json(['success' => true]);

		} catch (Exception $exception) {
			return response()->json(['success' => false, 'error' => $exception->getMessage()], 500);

		}
	}
}
