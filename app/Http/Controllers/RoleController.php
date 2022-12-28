<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Role_Acl;
use App\Models\Role_Translate;
use App\Models\Role_User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
	public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');
			
			if ($searchtext != '') {
				$list = Role::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orWhere('description', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Role::orderby($sort, $direction)->paginate($length);
			}
			
			return view('roles.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}
		
		return view('roles.index');
	}
	
	public function edit (Request $request, $id = 0) {
		$model = Role::findOrNew($id);
		
		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = array(
				'key' => 'Kulcs',
			);
			
			$rules = [
				'key' => 'required',
			];
			
			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('roles_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('Sikertelen mentés'),
					trans('A jogosultság adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}
			
			// data save
			$model->fill($request->all());
			$model->save();
			
			// Translates save
			foreach ($request->get('translate') as $lang => $t) {
				if (!$translate = $model->translates()->where('language_code', $lang)->first()) {
					$translate = new Role_Translate();
					$translate->role_id = $model->id;
					$translate->language_code = $lang;
				}
				$translate->name = $t['name'] ?: '';
				$translate->description = $t['description'] ?: '';
				$translate->save();
			}
			
			// Role ACLs save
			Role_Acl::where('role_id', $model->id)->delete();
			foreach ($request->get('role_acls', []) as $path) {
				$role_acl = new Role_Acl();
				$role_acl->role_id = $model->id;
				$role_acl->path = $path;
				$role_acl->save();
			}
			
			// Role Users save
			Role_User::where('role_id', $model->id)->delete();
			foreach ($request->get('role_users', []) as $user_id) {
				$role_user = new Role_User();
				$role_user->role_id = $model->id;
				$role_user->user_id = $user_id;
				$role_user->save();
			}
			
			return redirect(route('roles_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A jogosultság adatai sikeresen rögzítve lettek.'),
			]);
		}
		
		$routes = [];
		$users = [];
		if ($model->id) {
			$routeCollection = Route::getRoutes();
			foreach ($routeCollection as $value) {
				$routes[$value->getName()] = Role_Acl::where('role_id', $model->id)->where('path', $value->getName())->first() ? 1 : 0;
			}
			$users = User::orderBy('name', 'asc')->orderBy('name', 'asc')->get();
		}
		
		return view('roles.edit', [
			'model' => $model,
			'routes' => $routes,
			'users' => $users,
		]);
	}
	
	public function delete ($id) {
		if ($model = Role::find($id)) {
			$model->translates()->delete();
			$model->acls()->delete();
			$model->users()->delete();
			$model->delete();
			return redirect(route('roles_list'))->with('form_success_message', [
				trans('Sikeres törlés'),
				trans('A jogosultság sikeresen el lett távolítva.')
			]);
		}
	}
}
