<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'Api\AuthController@register')->name('auth.register');
Route::post('/login', 'Api\AuthController@login')->name('auth.login');
Route::post('/confirm', 'Api\AuthController@confirm')->name('auth.confirm');
Route::post('/resend', 'Api\AuthController@resend')->name('auth.resend');
Route::post('/refresh', 'Api\AuthController@refresh')->name('auth.refresh');
Route::post('/send-reset-link', 'Api\AuthController@sendResetLink')->name('auth.send-reset-link');
Route::post('/reset-password', 'Api\AuthController@resetPassword')->name('auth.reset-password');


Route::middleware(['auth:api', \App\Http\Middleware\LastSeen::class])->group(function () {

    /** Auth */
    Route::post('/logout', 'Api\AuthController@logout')->name('auth.logout');
    Route::post('/dashboard', 'Api\AuthController@dashboard')->name('auth.dashboard');
    Route::get('/get-user', 'Api\AuthController@getUser')->name('auth.get-user');


    Route::domain('test.com.ua')->group(function () {
        includeRouteFiles(__DIR__ . '/api/frontend/');
    });

    Route::domain('admin.com.ua')->group(function () {
        Route::group(
            [
                'namespace' => 'Api\\Admin',
                'middleware' => ['can:admin-panel'],
            ],
            function () {
                includeRouteFiles(__DIR__ . '/api/backend/');
            }
        );
    });

});

/** Preview pages */
Route::get('/preview/ensembles/{ref_token}', 'Api\EnsemblesController@showByRefToken');
Route::get('/preview/profile/{ref_token}', 'Api\ProfileController@showByRefToken');