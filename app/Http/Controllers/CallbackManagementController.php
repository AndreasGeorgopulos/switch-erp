<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Sale;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class CallbackManagementController extends Controller
{
	/**
	 * @return Application|RedirectResponse|Redirector
	 */
	public function index()
	{
		return redirect(route('callback_management_index_applicant'));
	}

	/**
	 * @param Request $request
	 * @return Factory|Application|View
	 */
	public function indexApplicant(Request $request)
	{
		return view('callback_management.index_applicant', [
			'site_title' => trans('Sales'),
			'site_subtitle' => 'Version 3.0',
			'breadcrumb' => [],
			'models' => Applicant::getCallbackApplicants(),
		]);
	}

	/**
	 * @param Request $request
	 * @return Factory|Application|View
	 */
	public function indexSales(Request $request)
	{
		return view('callback_management.index_sales', [
			'site_title' => trans('Sales'),
			'site_subtitle' => 'Version 3.0',
			'breadcrumb' => [],
			'models' => Sale::getCallbackSales(),
		]);
	}

	/**
	 * @param Request $request
	 * @return Application|RedirectResponse|Redirector
	 */
	public function deleteApplicant(Request $request)
	{
		if (!($model = Applicant::find($request->get('id')))) {
			abort(404);
		}

		$model->last_callback_date = null;
		$model->save();

		return redirect(route('callback_management_index_applicant'));
	}

	/**
	 * @param Request $request
	 * @return Application|RedirectResponse|Redirector
	 */
	public function deleteSales(Request $request)
	{
		if (!($model = Sale::find($request->get('id')))) {
			abort(404);
		}

		$model->callback_date = null;
		$model->save();

		return redirect(route('callback_management_index_sales'));
	}
}
