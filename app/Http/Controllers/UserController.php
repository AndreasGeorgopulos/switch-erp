<?php

// Admin felhasználó controller

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Role_User;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 *
 */
class UserController extends Controller
{
    // felhasználó kezelő oldal
	/**
	 * @param Request $request
	 * @return Factory|Application|View
	 */
	public function index (Request $request) {
    	if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');
			
			if ($searchtext != '') {
				$list = User::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orWhere('email', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = User::orderby($sort, $direction)->paginate($length);
			}
			
			return view('users.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}
		
        return view('users.index');
    }

	/**
	 * @param Request $request
	 * @param $id
	 * @return Factory|Application|RedirectResponse|Redirector|View
	 * @throws Exception
	 */
	public function edit (Request $request, $id = 0) {
	    $requiredRoleIds = [2, 3];
    	$model = User::findOrNew($id);

    	if (!$model->id) {
    		$model->active = 1;
		}
  
		// post request
    	if ($request->isMethod('post')) {
    		// validator settings
			$niceNames = array(
				'email' => trans('E-mail cím'),
				'name' => trans('Név'),
				'password' => trans('Jelszó'),
				'password_confirmation' => trans('Jelszó megerősítése'),
			);
			
    		$rules = [
    			'email' => 'required|email|unique:users,email,' . $model->id,
				'name' => 'required',
				'password' => !$model->id || !empty($request->get('password')) ? 'required|min:6|confirmed' : '',
				'password_confirmation' => !$model->id || !empty($request->get('password')) ? 'required|min:6' : '',
				'active' => ''
			];
    		
    		// form data validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('users_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Sikertelen mentés'),
					trans('A felhasználó adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}
			
			// form data save
			$model->fill($request->all());
			if (!empty($request->input('password'))) {
				$model->password = bcrypt($request->input('password'));
			}
			$model->save();

			$model->job_positions()->sync($request->get('job_positions', []));
			$model->applicant_groups()->sync($request->get('applicant_groups', []));

		    if (hasRole('admin_roles')) {
				$inputRoles = $request->input('roles', []);
				foreach ($requiredRoleIds as $item) {
					if (!in_array($item, $inputRoles)) {
						$inputRoles[] = $item;
					}
				}
				$model->roles()->sync($inputRoles);
		    }
		
			return redirect(route('users_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A felhasználó adatai sikeresen rögzítve lettek.')
			]);
		}

		$roles = [];
		foreach (Role::all() as $role) {
			$roles[$role->id] = [
				'key' => $role->key,
				'title' => $role->getTitle(),
				'enabled' => (bool) ($model->roles()->where('key', $role->key)->first() || (!$model->id && in_array($role->id, $requiredRoleIds))),
			];
		}

		$jobPositionIds = $model->job_positions()->pluck('id')->toArray();
	    $applicantGroupIds = $model->applicant_groups()->pluck('id')->toArray();

		return view('users.edit', [
			'model' => $model,
			'roles' => $roles,
			'jobPositionIds' => $jobPositionIds,
			'applicantGroupIds' => $applicantGroupIds,
		]);
	}

	/**
	 * @param $id
	 * @return Application|RedirectResponse|Redirector|void
	 * @throws Exception
	 */
	public function delete ($id) {
		if ($user = User::find($id)) {
			if (!$user->roles()->where('key', 'superadmin')->first()) {
				$user->delete();
				
				return redirect(route('users_list'))->with('form_success_message', [
					trans('Sikeres törlés'),
					trans('A felhasználó sikeresen el lett távolítva.')
				]);
			}
			else {
				return redirect(route('users_list'))->with('form_warning_message', [
					trans('Sikerestelen törlés'),
					trans('A felhasználó nem törölhető, mert superadmin jogosultsággal rendelkezik.')
				]);
			}
		}
	}

	/**
	 * @param $id
	 * @return Application|RedirectResponse|Redirector|void
	 */
	public function forceLogin ($id) {
    	if ($user = User::find($id)) {
		    Auth::logout();
    		Auth::login($user);
    		return redirect(route('applicant_management_index'));
		}
	}

	/**
	 * @param Request $request
	 * @return Factory|Application|RedirectResponse|Redirector|View
	 */
	public function profile (Request $request) {
		$model = Auth::user();

		// post request
		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = array(
				'password' => trans('Jelszó'),
				'password_confirmation' => trans('Jelszó megerősítése'),
			);

			$rules = [
				'password' => !$model->id || !empty($request->get('password')) ? 'required|min:6|confirmed' : '',
				'password_confirmation' => !$model->id || !empty($request->get('password')) ? 'required|min:6' : '',
			];

			// form data validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('users_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Sikertelen mentés'),
					trans('A felhasználó adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}

			// form data save
			$model->fill($request->all());
			if (!empty($request->input('password'))) {
				$model->password = bcrypt($request->input('password'));
			}
			$model->save();

			$model->job_positions()->sync($request->get('job_positions', []));
			$model->applicant_groups()->sync($request->get('applicant_groups', []));

			return redirect(route('users_profile', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A adataid sikeresen rögzítve lettek.')
			]);
		}

		$jobPositionIds = $model->job_positions()->pluck('id')->toArray();
		$applicantGroupIds = $model->applicant_groups()->pluck('id')->toArray();

		return view('users.profile', [
			'model' => $model,
			'jobPositionIds' => $jobPositionIds,
			'applicantGroupIds' => $applicantGroupIds,
		]);
	}
}
