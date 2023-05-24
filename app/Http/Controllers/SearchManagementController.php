<?php

namespace App\Http\Controllers;

use App\Models\ApplicantCompany;
use App\Models\Company;
use App\Models\JobPosition;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchManagementController extends Controller
{
    public function index($company = null, $job = null)
    {
	    $selectedCompany = $company !== null ? Company::where('id', $company)->first() : null;
	    $selectedJobPosition = $job !== null ? JobPosition::where('id', $job)->where('is_active', true)->first() : null;
	    $job_positions = null;

		$companies = Company::where(function ($q) {
				$q->where('is_active', true);
				$q->whereHas('job_positions', function ($q2) {
					$q2->where('is_active', true);
					if (!hasRole('super_administrator')) {
						$authJobPositionIds = Auth::user()->job_positions()->where('is_active', true)->pluck('id')->toArray();
						$q2->whereIn('id', $authJobPositionIds);
					}
				});
			})
			->orderBy('name', 'asc')
			->get();

		if ($selectedCompany) {
			$job_positions = JobPosition::where(function ($q) use($selectedCompany) {
					$q->where('is_active', true);
					$q->where('company_id', $selectedCompany->id);
					if (!hasRole('super_administrator')) {
						$authJobPositionIds = Auth::user()->job_positions()->where('is_active', true)->pluck('id')->toArray();
						$q->whereIn('id', $authJobPositionIds);
					}
				})
				->orderBy('title', 'asc')
				->get();
		}

		$models = !empty($selectedJobPosition) ? ApplicantCompany::getSearchModels($selectedJobPosition->id) : null;
		$counter = ApplicantCompany::getCouters($job);

	    return view('search_management.index', [
		    'site_title' => trans('Pozíciók'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'models' => $models,
		    'companies' => $companies,
		    'job_positions' => $job_positions,
		    'selectedCompany' => $selectedCompany,
		    'selectedJobPosition' => $selectedJobPosition,
		    'counter' => $counter,
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

	/**
	 * @return JsonResponse
	 */
	public function getCounters($job = null)
	{
		return response()->json([
			'counters' => ApplicantCompany::getCouters($job),
		]);
	}
}
