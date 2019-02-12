<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    /**
     * @return mixed
     */
    public function getAllSettings(){
        return auth()->user()->settings()->get();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSettings(Request $request){
        Setting::attach(auth()->user(),$request->all());
        return response()->json(['status' => 'success']);
    }
}
