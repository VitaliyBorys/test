<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function getRoles(Request $request){
        return array_pluck($request->user()->roles,'name');
    }
}
