<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request) {

    if (Request::getMethod() == "OPTIONS") {

    }

});

App::after(function($request, $response)
{
    // HTML Minification

    $minify = false;

    if(!Config::get('app.debug') || $minify)
    {
        if($response instanceof Illuminate\Http\Response)
        {
            $output = $response->getOriginalContent();
            // Clean comments
            //$output = preg_replace('/<!--([^\[|(<!)].*)/', '', $output);
            $output = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $output);
            // Clean some whitespace but leave some for \n
            $output = preg_replace('/\s{3,}/', ' ', $output);
            $output = preg_replace('/(\r?)/', '', $output);
            $response->setContent($output);
        }
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function() {
	if (Auth::guest()) {
		if (Request::ajax()) {
			return Response::make('Unauthorized', 401);
		} else {
			return Redirect::guest('/login');
		}
	}
});

Route::filter('auth.basic', function() {
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function() {
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf_json', function() {
	if (Session::token() !== Input::json('csrf_token')) {
		throw new Illuminate\Session\TokenMismatchException;
	}
});


Route::filter('event.pageview_throttle', 'filters\EventPageViewThrottleFilter');