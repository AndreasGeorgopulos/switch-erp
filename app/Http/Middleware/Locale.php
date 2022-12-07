<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Cookie::has('locale')) {
            App::setLocale(Cookie::get('locale'));
        } else {
        	Cookie::queue(Cookie::make('locale', config('app.locale'), config('app.language_cookie_expires')));
        }
        return $next($request);
    }
}
