<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacation;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class VacationController extends Controller
{
	/**
	 * Load profile vacations via AJAX.
	 *
	 * @param Request $request
	 * @return View
	 */
	public function ajaxLoadProfileVacations(Request $request): View
	{
		$this->validateAjaxRequest($request);

		$userModel = User::findOrFail(Auth::user()->id ?? null);

		return view('users.vacations._list', [
			'userModel' => $userModel,
		]);
	}

	/**
	 * Save profile vacation via AJAX.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function ajaxSaveProfileVacation(Request $request): JsonResponse
	{
		$this->validateAjaxRequest($request);

		$validator = Validator::make( $request->all(), Vacation::rules(), Vacation::customMessages() );
		$validator->setAttributeNames( Vacation::niceNames() );
		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()->toArray(),
			]);
		}

		$vacationModel = Vacation::findOrNew($request->get('id'));
		$vacationModel->fill($request->all());
		if (empty($vacationModel->user_id)) {
			$vacationModel->user_id = Auth::user()->id ?? null;
		}

		if (!$vacationModel->save()) {
			throw new RuntimeException('Model save failed: ' . Vacation::class . ' #' . $vacationModel->id);
		}

		return response()->json([
			'success' => true,
			'days_per_year' => $vacationModel->user->vacation_days_per_year,
			'free_days' => $vacationModel->user->free_vacation_days,
			'used_days' => $vacationModel->user->used_vacation_days,
		]);
	}

	/**
	 * Delete profile vacation via AJAX.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 * @throws Exception
	 */
	public function ajaxDeleteProfileVacation(Request $request): JsonResponse
	{
		$this->validateAjaxRequest($request);

		$id = $request->get('id');
		$vacationModel = Vacation::findOrFail($id);
		if (!$vacationModel->isDeletable()) {
			throw new NotFoundResourceException('Model not deletable: ' . Vacation::class . ' #' . $id);
		}

		if (!$vacationModel->delete()) {
			throw new RuntimeException('Model delete failed: ' . Vacation::class . ' #' . $vacationModel->id);
		}

		return response()->json([
			'success' => true,
			'days_per_year' => $vacationModel->user->vacation_days_per_year,
			'free_days' => $vacationModel->user->free_vacation_days,
			'used_days' => $vacationModel->user->used_vacation_days,
		]);
	}

	/**
	 * Validate that the request is an AJAX call.
	 *
	 * @param Request $request
	 * @return void
	 * @throws NotAcceptableHttpException
	 */
	private function validateAjaxRequest(Request $request): void
	{
		if (!$request->ajax()) {
			throw new NotAcceptableHttpException('This HTTP request is not an AJAX call.');
		}
	}
}