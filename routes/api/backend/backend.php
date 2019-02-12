<?php
Route::get('/', 'DashboardController@index');
Route::get('profile/roles', 'RoleController@getRoles');


Route::namespace('User')->group(function () {
    Route::put('/user/set-status-confirm', 'ResourceController@statusConfirm');
    Route::resource('/user', 'ResourceController');
    Route::post('/user/{id}/upload-avatar', 'ResourceController@uploadAvatar');
    Route::get('roles-list', 'RoleController@listRoles');
});

Route::resource('/prize', 'Prize\\ResourcePrizeController');

Route::get('/settings','SettingController@getAllSettings');
Route::post('/settings','SettingController@updateSettings');

