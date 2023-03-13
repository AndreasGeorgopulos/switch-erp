<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SalesManagementController extends Controller
{
	/**
	 * @param Request $request
	 * @return Factory|Application|View
	 */
	public function index(Request $request)
    {
	    $getParams = [
		    'company_name' => $request->get('company_name', null),
		    'status' => $request->get('status', null),
		    'callback_date' => $request->get('callback_date', null),
		    'contact' => $request->get('contact', null),
		    'position' => $request->get('position', null),
		    'phone' => $request->get('phone', null),
		    'email' => $request->get('email', null),
		    'information' => $request->get('information', null),
		    'last_contact_date' => $request->get('last_contact_date', null),
		    'web' => $request->get('web', null),
		    'monogram' => $request->get('monogram', null),
	    ];

	    $sales = Sale::where(function ($q) use ($getParams) {
			foreach ($getParams as $k => $v) {
				if (empty($v)) {
					continue;
				}

				if ($k == 'information') {
					$q->where($k, 'like', '%' . $v . '%');
				} else {
					$q->where($k, $v);
				}
			}
	    })->orderBy('sort', 'desc')->get();

	    return view('sales_management.index', [
		    'site_title' => trans('Sales'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'sales' => $sales,
		    'getParams' => $getParams,
	    ]);
    }

	/**
	 * @param Request $request
	 * @return void
	 */
	public function add(Request $request)
	{
		if ( ( $sales = $request->get('sales', null) ) === null ) {
			throw new NotFoundHttpException('Model not found');
		}

		foreach ($sales as $item) {
			$model = new Sale();
			$model->setNextSortValue();
			$model->fill($item)->save();
		}

		return redirect(route('sales_management_index'))->with( 'form_success_message', [
			trans( 'Sikeres mentés' ),
			trans( 'A cégek sikeresen rögzítve lettek.' ),
		] );
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function update(Request $request)
	{
		$result = [
			'success' => true,
		];

		try {
			$sales = $request->get('sales', []);
			foreach ($sales as $id => $params) {
				if (!($model = Sale::where('id', $id)->first())) {
					throw new Exception('The sale model not found. #' . $id);
				}

				foreach ($params as $field => $value) {
					$model->$field = $value;
				}

				if (!$model->save()) {
					throw new Exception('The sale model save failed. #' . $id);
				}
			}

		} catch (Exception $exception) {
			$result['success'] = false;
			$result['error'] = $exception->getMessage();
			return response()->json($result, 500);

		}

		return response()->json($result, 200);
	}

	public function delete($id)
	{
		if (!($model = Sale::where('id', $id)->first())) {
			throw new Exception('The sale model not found. #' . $id);
		}
		$model->delete();

		return redirect(route('sales_management_index'));
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function reorder(Request $request): JsonResponse
	{
		$result = [
			'success' => true,
		];

		try {
			$ids = array_reverse($request->get('ids', []));
			foreach ($ids as $sort => $id) {
				if (!($model = Sale::where('id', $id)->first())) {
					continue;
				}

				$model->sort = ($sort + 1);
				$model->save();
			}

		} catch (Exception $exception) {
			$result['success'] = false;
			$result['error'] = $exception->getMessage();
			return response()->json($result, 500);
		}

		return response()->json(null, 200);
	}
}
