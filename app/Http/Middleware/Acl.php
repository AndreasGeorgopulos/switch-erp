<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$routeName = Route::getFacadeRoot()->current()->getName();
		
		if (!Auth::check() && !in_array($routeName, ['index','login'])) {
			//abort(401);
			return redirect()->intended(route('login'));
		}
		else if (Auth::check() && !$this->checkAccessForUri($routeName)) {
			//abort(401);
			return redirect()->intended(route('applicant_management_index'));
		}
	
		return $next($request);
    }
	
	private function checkAccessForUri ($uri)
	{
		$can = false;
		if ($user = User::find(Auth::user()->id)) {
			$roles = $user->roles;
			foreach ($roles as $role) {
				if ($role->key == "superadmin") {
					$can = true;
					break;
				}
				foreach ($role->acls as $acls) {
					if ($acls->path == $uri) {
						$can = true;
					}
				}
			}
		}
		return $can;
	}
}
