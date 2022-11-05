<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class LangWare
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
       
        if (Session::has('applocale') AND array_key_exists(Session::get('applocale'), Config::get('languages'))) {
            App::setLocale(Session::get('applocale'));
            // dd(session()->get('applocale'));
        } else {
            App::setLocale(Config::get('app.fallback_locale'));
            // dd("j");
        }
        return $next($request);
        
    }
}
