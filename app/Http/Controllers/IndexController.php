<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
	use AuthenticatesUsers;
	
	protected $redirectTo = '/';
	
	public function index (Request $request) {
		return view(Auth::check() ? 'dashboard' : 'login');
	}
	
	public function logout () {
    	Auth::logout();
    	return redirect(route('index'));
	}
	
	public function changeLanguage ($locale) {
		if (!in_array($locale, config('app.languages'))) {
			$locale = config('app.locale');
		}
		
		App::setLocale($locale);
		Cookie::queue(Cookie::make('locale', $locale, config('app.language_cookie_expires')));
		
		$referrer = request()->headers->get('referer') ?: '/';
		
		return redirect($referrer);
	}
}
