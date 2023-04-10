<?php

namespace App\Http\Controllers;

use App\Models\ApplicantCompany;
use Illuminate\Http\Request;

class WorkManagementController extends Controller
{
    public function index()
    {
		$models = ApplicantCompany::getWorkModels();

	    return view('work_management.index', [
		    'site_title' => trans('Elhelyezések'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'models' => $models,
		    /*'companies' => $companies,
		    'job_positions' => $job_positions,
		    'selectedCompany' => $selectedCompany,
		    'selectedJobPosition' => $selectedJobPosition,*/
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
			foreach(['salary', 'work_begin_date', 'follow_up', 'monogram'] as $field) {
				$updateFields[$field] = $request->get($field);
			}

			$model->update($updateFields);

			return response()->json(['success' => true]);

		} catch (Exception $exception) {
			return response()->json(['success' => false, 'error' => $exception->getMessage()], 500);

		}
	}
}
