<?php

namespace App\Http\Controllers;

use App\Models\ApplicantGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Applicant group management controller
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 */
class ApplicantGroupController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');

			if ($searchtext != '') {
				$list = ApplicantGroup::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = ApplicantGroup::orderby($sort, $direction)->paginate($length);
			}

			return view('applicant_groups.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}

		return view('applicant_groups.index');
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function edit (Request $request, int $id = 0) {
		$model = ApplicantGroup::findOrNew($id);

		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = ['name' => 'Név'];
			$rules = ['name' => 'required'];

			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('applicant_groups_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Sikertelen mentés'),
					trans('A jelölt csoport adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}

			// data save
			$model->fill($request->all());
			$model->save();

			return redirect(route('applicant_groups_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A jelölt csoport adatai sikeresen rögzítve lettek.'),
			]);
		}

		return view('applicant_groups.edit', [
			'model' => $model,
		]);
	}

	/**
	 * @param int $id
	 * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
	 * @throws \Exception
	 */
	public function delete ($id) {
		if ($model = ApplicantGroup::find($id)) {
			$model->delete();
			return redirect(route('applicant_groups_list'))->with('form_success_message', [
				trans('Sikeres törlés'),
				trans('A jelölt csoport sikeresen el lett távolítva.')
			]);
		}
	}
}
