<?php

namespace App\Http\Middleware;

use App;
use Session;
use Closure;
use Config;
use Lang;
use Carbon\Carbon;
use App\Helpers\LocaleUtils;

class Locale
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
        $locale = Session::get('locale') ? Session::get('locale') : config('app.fallback_locale');
        Session::put('locale', $locale);
        app()->setLocale($locale);

        return $next($request);
    }
}
