<?php
/** Profile */
Route::put('/profile', 'Api\ProfileController@update')->name('profile.update');
Route::post('/profile/upload-avatar', 'Api\ProfileController@uploadAvatar');
Route::get('/profile/', 'Api\ProfileController@getUser');
Route::get('/get-prize','Api\PrizeController@getRandomPrize');
Route::get('/prizes','Api\\PrizeController@getPrizes');

Route::get('/prize/refuse','Api\\PrizeController@refuse');
Route::get('/prize/sent','Api\\PrizeController@sent');
Route::get('/prize/transform','Api\\PrizeController@transform');

Route::get('profile/convert','Api\ProfileController@convert');
Route::get('profile/sendToCard','Api\ProfileController@withdraw');