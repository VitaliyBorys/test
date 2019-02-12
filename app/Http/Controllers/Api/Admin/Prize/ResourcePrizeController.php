<?php

namespace App\Http\Controllers\Api\Admin\Prize;

use App\Http\Resources\Admin\PrizeResource;
use App\Models\Prize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourcePrizeController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        /** @var Prize[] $prizes */
        $prizes = Prize::orderBy('created_at', 'DESC')->paginate(25);
        return PrizeResource::collection($prizes);
    }


    /**
     * @param int $id
     * @return PrizeResource
     */
    public function show(int $id)
    {
        /** @var Prize $prize */
        $prize = Prize::findOrFail($id);
        return new PrizeResource($prize);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2',
            'poster' => 'required|min:1|url'
        ]);

        /** @var Prize $prize */
        $prize = (new Prize())->fill($request->all());
        $prize->save();

        return response()->json(['status' => 'success', 'prize_id' => $prize->id], 200);
    }


    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,int $id)
    {
        /** @var Prize $prize */
        $prize = Prize::findOrFail($id);
        $prize->update($request->all());
        return response()->json(['status' => 'success', 'prize_id' => $prize->id], 200);
    }
}
