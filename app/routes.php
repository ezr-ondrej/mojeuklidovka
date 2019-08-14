<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Config::set('laravel-debugbar::config.enabled', Config::get('app.debug'));

Route::get('login', array('uses' => 'HomeController@pageLogin'));
Route::get('auth/status', array('uses' => 'AuthController@status'));
Route::get('auth/logout', array('uses' => 'AuthController@logout'));
Route::post('auth/login', array('uses' => 'AuthController@login'));

Route::get('space', array('as' => 'space.home', function()
{
    if (Auth::check()) {
        return Redirect::to('space/blog');
    } else {
        return Redirect::to('login');
    }
}));

// === API ROUTES ===
Route::group(array('prefix' => 'space', 'before' => 'auth'), function() {

    Route::get('blog', 'BlogController@indexAdmin');
    Route::get('blog/create', 'BlogController@create');
    Route::get('blog/edit/{id}', 'BlogController@get');
    Route::get('blog/delete/{id}', 'BlogController@destroy');
    Route::post('blog/{id}', 'BlogController@update');
    Route::post('blog', array(
        'uses' => 'BlogController@store',
        'as' => 'storeBlog'
    ));

    Route::get('reviews', 'ReviewController@getAll');
    Route::get('review/{id}', 'ReviewController@get');

    Route::get('news', 'NewsController@indexAdmin');
    Route::get('news/create', 'NewsController@create');
    Route::get('news/edit/{id}', 'NewsController@get');
    Route::get('news/delete/{id}', 'NewsController@destroy');
    Route::post('news/{id}', 'NewsController@update');
    Route::post('news', array(
        'uses' => 'NewsController@store',
        'as' => 'storeNews'
    ));

    Route::get('career', 'CareerController@indexAdmin');
    Route::get('career/create', 'CareerController@create');
    Route::get('career/edit/{id}', 'CareerController@get');
    Route::get('career/delete/{id}', 'CareerController@destroy');
    Route::post('career/{id}', 'CareerController@update');
    Route::post('career', array(
        'uses' => 'CareerController@store',
        'as' => 'storeCareer'
    ));

});

Route::get('review', 'ReviewController@index');
Route::get('review-success', 'ReviewController@index');
Route::post('review', 'ReviewController@store');

Route::post('sent', array(
    'uses' => 'OrderController@orderSubmit',
    'as' => 'orderSubmit'
));

Route::post('kontaktni-formular-odeslan', array(
    'uses' => 'FormController@contactFormSubmit',
    'as' => 'contactFormSubmit'
));

Route::get('uklidove-sluzby', array(
    'uses' => 'HomeController@pageServices',
    'as' => 'pageServices'
));

Route::get('uklid-domacnosti', array(
    'uses' => 'HomeController@pageHome',
    'as' => 'pageHome'
));

Route::get('uklid-bytovych-domu', array(
    'uses' => 'HomeController@pageFlats',
    'as' => 'pageFlats'
));

Route::get('uklid-spolecnych-prostor', array(
    'uses' => 'HomeController@pageFloor',
    'as' => 'pageFloor'
));

Route::get('uklid-bytu', array(
    'uses' => 'HomeController@pageFlat',
    'as' => 'pageFlat'
));

Route::get('uklid-kancelari', array(
    'uses' => 'HomeController@pageOffice',
    'as' => 'pageOffice'
));

Route::get('uklid-kancelari-praha-1', array(
    'uses' => 'HomeController@pageOfficePrague1',
    'as' => 'pageOfficePrague1'
));

Route::get('uklid-kancelari-praha-2', array(
    'uses' => 'HomeController@pageOfficePrague2',
    'as' => 'pageOfficePrague2'
));

Route::get('uklid-kancelari-praha-4', array(
    'uses' => 'HomeController@pageOfficePrague4',
    'as' => 'pageOfficePrague4'
));

Route::get('uklid-kancelari-praha-6', array(
    'uses' => 'HomeController@pageOfficePrague6',
    'as' => 'pageOfficePrague6'
));

Route::get('uklid-kancelari-praha-8', array(
    'uses' => 'HomeController@pageOfficePrague8',
    'as' => 'pageOfficePrague8'
));

Route::get('uklid-kancelari-praha-12', array(
    'uses' => 'HomeController@pageOfficePrague12',
    'as' => 'pageOfficePrague12'
));


Route::get('nase-vize', array(
    'uses' => 'HomeController@pageVision',
    'as' => 'pageVision'
));

Route::get('kontakt', array(
    'uses' => 'HomeController@pageContact',
    'as' => 'pageContact'
));

Route::get('objednat-uklid', array(
    'uses' => 'HomeController@pageOrder',
    'as' => 'pageOrder'
));

Route::get('uklid-otazky-odpovedi', array(
    'uses' => 'HomeController@pageQA',
    'as' => 'pageQA'
));

Route::get('proc-uklid-od-nas', array(
    'uses' => 'HomeController@pageWhyUs',
    'as' => 'pageWhyUs'
));

Route::get('blog', array(
    'uses' => 'BlogController@index',
    'as' => 'pageBlog'
));
Route::get('blog/{slug}', 'BlogController@index');

Route::get('novinky', array(
    'uses' => 'NewsController@index',
    'as' => 'pageNews'
));
Route::get('novinky/{slug}', 'NewsController@index');

Route::get('kariera', array(
    'uses' => 'CareerController@index',
    'as' => 'pageCareer'
));
Route::get('kariera/uklid-kancelari', array(
    'uses' => 'CareerController@offices',
    'as' => 'pageCareerOffice'
));
Route::get('kariera/uklid-domacnosti', array(
    'uses' => 'CareerController@home',
    'as' => 'pageCareerHome'
));
Route::get('kariera/bytove-domy', array(
    'uses' => 'CareerController@flats',
    'as' => 'pageCareerFlats'
));

Route::get('uklid-domu', function(){
    return Redirect::to('uklid-bytu', 301);
});

Route::get('/', array(
    'uses' => 'HomeController@index',
    'as' => 'home'
));

// Display all SQL executed in Eloquent
/*
Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});*/
