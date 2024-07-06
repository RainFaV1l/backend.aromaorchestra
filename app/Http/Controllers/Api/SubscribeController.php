<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscribe\StoreRequest;
use App\Http\Resources\SubscribeResource;
use App\Models\Subscribe;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SubscribeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $subscribe = Subscribe::query()->create($data);

        return new SubscribeResource($subscribe);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subscribe::query()->findOrFail($id)->delete();

        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
