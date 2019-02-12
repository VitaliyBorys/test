<?php
Route::domain('test.com.ua')->group(function () {
    /** Mails */
    Route::get('/mail/confirm-registration', function () {
        $user = \App\User::inRandomOrder()->first();
        return new \App\Mail\ConfirmRegistration($user);
    });

    Route::get('/mail/reset-link', function () {
        $user = \App\User::inRandomOrder()->first();
        return new \App\Mail\ResetLinkMail($user);
    });

    Route::get('/login/{provider}', 'Api\SocialAuthController@redirectToProvider')->name('facebook');
    Route::get('/api/socialite/{provider}', 'Api\SocialAuthController@handleProviderCallback');

    Route::get('/{path?}', function () {

        return view('index');
    })->where('path', '(.*)');
});

Route::domain('admin.com.ua')->group(function () {
    Route::get('/{path?}', function () {
        return view('admin');
    })->where('path', '(.*)');
});