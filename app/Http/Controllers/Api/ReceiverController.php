<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Receivers\ReceiverStoreRequest;
use App\Http\Requests\Api\Receivers\ReceiverUpdateRequest;
use App\Http\Resources\ReceiverResource;
use App\Services\ReceiverService;
use Exception;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
    public function __construct(private ReceiverService $receiverService)
    {

    }

    /**
     * get all receivers
     */
    public function index(Request $request)
    {
        try {
            $filters = array_filter($request->all());
            $withRelations = ['branch.company:id,name', 'city:id,title', 'area:id,title','defaultAddress'];
            $receivers = $this->receiverService->listing(filters: $filters, withRelations: $withRelations);
            return ReceiverResource::collection($receivers);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: $e->getCode());
        }
    }

    public function store(ReceiverStoreRequest $request)
    {
        try {
            $this->receiverService->store(data: $request->validated());
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function update(ReceiverUpdateRequest $request, int $id)
    {
        try {
            $this->receiverService->update(id: $id, data: $request->validated());
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception|NotFoundException $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    /**
     * delete existing receiver
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            $this->receiverService->destroy(id: $id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }
}
