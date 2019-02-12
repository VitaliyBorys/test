<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Resources\Admin\RoleResource;
use App\Models\User\RBAC\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function listRoles(Request $request){
        return RoleResource::collection(Role::all());
    }
}
