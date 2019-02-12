<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PrizeResource;
use App\Models\Prize;
use App\Models\Setting;
use App\Models\UserPrize;
use App\Service\PrizeService;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrizeController extends Controller
{
    private $prizeType = ['physical', 'bonus', 'money'];


    /** @var PrizeService $service */
    private $service;

    public function __construct()
    {
        $this->service = new PrizeService(new Prize(), Setting::getLimitMoneyValue());
    }


    /**
     * @param Request $request
     * @return array
     */
    public function getRandomPrize(Request $request)
    {
        /** @var array $prize */
        $prize = $this->service->getPrize($this->prizeType[array_rand($this->prizeType)]);

        /** @var User $user */
        $user = auth()->user();
        /** @var UserPrize $prize */
        $prize = UserPrize::add($user, $prize);

        return response()->json(['message' => strip_tags($prize->getTitle())], 200);
    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPrizes()
    {
        return PrizeResource::collection(auth()->user()->prizes()->orderBy('created_at', 'DESC')->paginate(20));
    }


    public function transform()
    {
        $this->validatePrize();

        /** @var UserPrize $prize */
        $prize = $this->getPrize('bonus');

        $prize->convert(auth()->user());
    }

    public function sent()
    {
        $this->validatePrize();

        /** @var UserPrize $prize */
        $prize = $this->getPrize('physical');

        $prize->sent();
    }

    public function refuse()
    {
        $this->validatePrize();
        /** @var UserPrize $prize */
        $prize = $this->getPrize();
        $prize->refuse(\request()->user());

    }

    private function validatePrize()
    {
        $this->validate(request(), [
            'prize_id' => 'required|exists:' . (new UserPrize())->getTable() . ',id'
        ]);
    }

    private function getPrize($type = null)
    {

        /** @var Builder $builder */
        $builder = UserPrize::where('user_id', \request()->user()->id)
            ->where('status', UserPrize::STATUS_NEW)
            ->where('id', \request(['prize_id']));

        if ($type) {
            $builder->where('prize_type', $type);
        }
        $prize = $builder->get();

        return $prize[0];
    }
}
