<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Helpers\ImageUpload;
use App\Http\Requests\Admin\User\UserCreateRequest;
use App\Http\Resources\Admin\ProfileResource;
use App\Http\Resources\Admin\UserResource;
use App\Repositories\Users;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{

    /** @var Users $rep */
    private $rep;

    public function __construct(Users $users)
    {
        $this->rep = $users;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        /** @var User[] $users */
        $users = User::orderBy('created_at', 'DESC')->paginate(25);
        return UserResource::collection($users);
    }


    /**
     * @param int $id
     * @return ProfileResource
     */
    public function show(int $id)
    {
        /** @var User[] $users */
        $user = User::findOrFail($id);
        return new ProfileResource($user);
    }

    /**
     * @param UserCreateRequest $request
     * @param Users $users
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCreateRequest $request, Users $users)
    {
        $user = new User();
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();
        $users->update($user, $request->all());

        return response()->json(['status' => 'success', 'user_id' => $user->id], 200);
    }


    /**
     * @param UserCreateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserCreateRequest $request, int $id)
    {
        $user = User::findOrFail($id);
        $this->rep->update($user, $request->all());
        if (!empty($request['password']) && !empty($request['password_confirmation'])) {
            $user->password = bcrypt($request['password']);
            $user->save();
        }
        return response()->json(['status' => 'success', 'user_id' => $user->id], 200);
    }


    /**
     * @param ImageUpload $image_upload
     * @param null|int $id
     * @return false|string
     */
    public function uploadAvatar(ImageUpload $image_upload, $id = null)
    {
        $this->validate(\request(), [
            'avatar' => 'mimes:jpeg,bmp,png'
        ]);
        $user = $id ? User::findOrFail($id) : new User();

        return $image_upload->upload('avatar', $user);
    }

    public function destroy($id)
    {
        //
    }


    /**
     * @param Request $request
     */
    public function statusConfirm(Request $request)
    {
        $this->validate($request, ['id' => 'required', 'status' => 'required']);
        User::where('id', $request->input('id'))
            ->update([
                'confirmed' => $request->input('status')
            ]);
    }
}
