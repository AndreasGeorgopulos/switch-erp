<?php

namespace App\Http\Controllers;

use App\Models\ApplicantCompany;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkManagementController extends Controller
{
	/**
	 * @return Factory|Application|View
	 */
	public function index()
    {
        $year = request()->get('year', date('Y'));
		$models = ApplicantCompany::getWorkModels($year);

	    return view('work_management.index', [
		    'site_title' => trans('Elhelyezések'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'models' => $models,
            'year' => $year,
	    ]);
    }

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function saveData(Request $request): JsonResponse
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
			foreach(['salary', 'work_begin_date', 'follow_up', 'monogram', 'source'] as $field) {
				$updateFields[$field] = $request->get($field);
			}

			$model->update($updateFields);

			return response()->json(['success' => true]);

		} catch (Exception $exception) {
			return response()->json(['success' => false, 'error' => $exception->getMessage()], 500);

		}
	}

	/**
	 * @param Request $request
	 * @param int $applicant_id
	 * @param int $job_position_id
	 * @return Application|RedirectResponse|Redirector
	 */
	public function uploadTig(Request $request, int $applicant_id, int $job_position_id)
	{
		$model = $this->findModel($applicant_id, $job_position_id);
		if ( !( $file = $request->file('tig_file') ) ) {
			abort(404);
		}

		$model->deleteTIG();
		try {
			$model->deleteTIG();
			if ( $file ) {
				$model->uploadTIG($file);
			}
		} catch ( Exception $exception ) {
			return redirect( route( 'work_management_index' ) )
				->withErrors( $exception->getMessage() )
				->withInput()
				->with( 'form_warning_message', [
					trans( 'Sikertelen TIG feltöltés' ),
					trans( $exception->getMessage() ),
				] );
		}

		return redirect( route( 'work_management_index' ) )
			->with( 'form_success_message', [
				trans( 'Sikeres TIG feltöltés' ),
				trans( 'A teljesítés igazolás sikeresen fel lett töltve.' ),
			] );
	}

	/**
	 * @param int $applicant_id
	 * @param int $job_position_id
	 * @return Application|RedirectResponse|Redirector
	 */
	public function deleteTig(int $applicant_id, int $job_position_id)
	{
		$model = $this->findModel($applicant_id, $job_position_id);
		$model->deleteTIG();

		return redirect( route( 'work_management_index' ) )
			->with( 'form_success_message', [
				trans( 'Sikeres TIG törlés' ),
				trans( 'A teljesítés igazolás sikeresen el lett távolítva.' ),
			] );
	}

	/**
	 * @param int $applicant_id
	 * @param int $job_position_id
	 * @return BinaryFileResponse
	 */
	public function downloadTig(int $applicant_id, int $job_position_id): BinaryFileResponse
	{
		$model = $this->findModel($applicant_id, $job_position_id);

		return response()->download($model->getTIGPath(), $model->tig_file, [], 'inline');
	}

	/**
	 * @param int $applicant_id
	 * @param int $job_position_id
	 * @return ApplicantCompany
	 */
	private function findModel(int $applicant_id, int $job_position_id): ApplicantCompany
	{
		/** @var ApplicantCompany $model */
		$model = ApplicantCompany::where(function ($q) use($applicant_id, $job_position_id) {
			$q->where('applicant_id', $applicant_id);
			$q->where('job_position_id', $job_position_id);
		})->first();

		if (!$model) {
			throw new NotFoundHttpException('ApplicantCompany model not found.');
		}

		return $model;
	}
}
