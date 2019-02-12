<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\ImageUpload;
use App\Models\Prize;
use App\Models\Setting;
use App\Repositories\Users;
use App\Rules\PasswordCheck;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\Controller;
use App\Service\BankService;
use App\Service\PrizeService;
use App\User;

class ProfileController extends Controller
{
    /**
     * @var BankService
     */
    private $service;


    /**
     * @var PrizeService
     */
    private $prizeService;

    public function __construct(BankService $service)
    {
        $this->service = $service;
        $this->prizeService = new PrizeService(new Prize(), Setting::getLimitMoneyValue());
    }


    /**
     * @return UserResource
     */
    public function getUser()
    {
        return new UserResource(auth()->user());
    }


    /**
     * @param Users $user
     */
    public function update(Users $user)
    {
        $rules = [
            'birthday' => 'date|before:' . now()->toDateString(),
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'gender' => 'required',
            'lastname' => 'max:255',
            'name' => 'required|max:255',
            'phone' => 'max:255',
            'password' => [new PasswordCheck()],
            'new_password' => 'min:6|confirmed',

        ];
        request()->validate($rules);

        $user->update(auth()->user(), request()->all());
    }


    /**
     * @param ImageUpload $image_upload
     * @return false|string
     */
    public function uploadAvatar(ImageUpload $image_upload)
    {
        return $image_upload->upload('avatar', auth()->user());
    }


    /**
     *
     */
    public function withdraw()
    {

        /** @var User $user */
        $user = \request()->user();

        if ($user->money > 0) {
            $this->service->transaction($user->getNumberCard(), $user->money);
            $user->emptyYourWallet();

        } else {
            throw new \DomainException('На вашем счету нету денег');
        }
    }

    public function convert()
    {
        /** @var User $user */
        $user = auth()->user();
        $this->prizeService->convertBonusToMoney($user, Setting::getKoefTransform());
        return response()->json(['message' => 'success']);
    }
}
