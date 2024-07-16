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
    public function index($job = null)
    {
	    $selectedJobPosition = $job !== null ? JobPosition::where('id', $job)->where('is_active', true)->first() : null;
        $job_positions = $this->getJobPositions();
		$models = !empty($selectedJobPosition) ? ApplicantCompany::getSearchModels($selectedJobPosition->id) : null;
		$counter = ApplicantCompany::getCouters($job);

	    return view('search_management.index', [
		    'site_title' => trans('Pozíciók'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'models' => $models,
		    'job_positions' => $job_positions,
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

    private function getJobPositions()
    {
        return JobPosition::with('company')
            ->join('companies', 'job_positions.company_id', '=', 'companies.id')
            ->where(function ($q) {
                $q->where('job_positions.is_active', true);
                if (!hasRole('super_administrator')) {
                    $authJobPositionIds = Auth::user()->job_positions()->where('is_active', true)->pluck('job_positions.id')->toArray();
                    $q->whereIn('job_positions.id', $authJobPositionIds);
                }
            })
            ->orderBy('companies.name', 'asc')
            ->orderBy('job_positions.title', 'asc')
            ->select('job_positions.*')  // Ez biztosítja, hogy a JobPosition modellek kerülnek visszaadásra
            ->get();
    }
}
