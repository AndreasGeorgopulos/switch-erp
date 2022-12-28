<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
	public function Login (Request $request)
	{
		if ($request->isMethod('post')) {

			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
				'password' => 'required',
			]);

			$validator->setAttributeNames([
				'email' => trans('E-mail address'),
				'password' => trans('Password'),
			]);

			if ($validator->fails()) {
				return redirect(route('login'))->withErrors($validator)->withInput();
			}

			if (!Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')/*, 'is_active' => 1*/])) {
				$validator->errors()->add('email', trans('E-mail address or password is not valid!'));
				return redirect(route('login'))->withErrors($validator)->withInput();
			}

			return redirect(route('applicant_management_index'));
		}

		return view('login');
	}

	public function Logout ()
	{
		Auth::logout();
		//Auth::logoutCurrentDevice();
		//Auth::logoutOtherDevices('aA123456');
		return redirect(route('login'));
	}

	public function Dashboard ()
	{
		return view('dashboard', [
			'site_title' => trans('Dashboard'),
			'site_subtitle' => 'Version 3.0',
			'breadcrumb' => [],
		]);
	}
}
