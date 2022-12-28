<?php

// Admin felhasználó controller

namespace App\Http\Controllers;

use App\Role;
use App\Role_User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // felhasználó kezelő oldal
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
    
    public function edit (Request $request, $id = 0) {
    	// model
    	$model = User::findOrNew($id);
    	
    	// tabs
    	$tabs = [
    		['href' => 'general_data', 'title' => trans('Általános adatok'), 'include' => 'users.tab_general']
		];
    	if ($model->id) {
    		// check user roles
    		if (Auth::user()->roles()->where('key', 'superadmin')->orWhere('key', 'roles')->first()) {
				$tabs[] = ['href' => 'role_data', 'title' => trans('Jogosultágok'), 'include' => 'users.tab_roles'];
			}
		}
		else {
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
				'password' => !$model->id || $request->get('password') ? 'required|min:6|confirmed' : '',
				'password_confirmation' => !$model->id || $request->get('password') ? 'required|min:6' : '',
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
			$model->save();
			
			// role settings save
			// check user roles
			if (Auth::user()->roles()->where('key', 'superadmin')->orWhere('key', 'roles')->first()) {
				Role_User::where('user_id', $model->id)->delete();
				foreach ($request->get('roles', []) as $roleId) {
					$role_user = new Role_User();
					$role_user->user_id = $model->id;
					$role_user->role_id = $roleId;
					$role_user->save();
				}
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
				'enabled' => (bool) $model->roles()->where('key', $role->key)->first(),
			];
		}

		return view('users.edit', [
			'model' => $model,
			'roles' => $roles,
			'tabs' => $tabs
		]);
	}
	
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
	
	public function forceLogin ($id) {
    	if ($user = User::find($id)) {
		    Auth::logout();
    		Auth::login($user);
    		return redirect(route('applicant_management_index'));
		}
	}
}
