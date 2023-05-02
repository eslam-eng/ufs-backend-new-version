<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Receivers\ReceiverStoreRequest;
use App\Http\Requests\Api\Receivers\ReceiverUpdateRequest;
use App\Http\Resources\Receiver\ReceiverEditResource;
use App\Http\Resources\Receiver\ReceiverResource;
use App\Services\ReceiverService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $withRelations = ['branch.company:id,name','defaultAddress'];
            $receivers = $this->receiverService->listing(filters: $filters, withRelations: $withRelations);
            return ReceiverResource::collection($receivers);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: $e->getCode());
        }
    }

//    public function show(int $id)
//    {
//        try {
//            $withRelations = ['branch.company:id,name','addresses'=>fn($query)=>$query->with(['city','area'])];
//            $receiver = $this->receiverService->findById(id: $id, withRelations: $withRelations);
//            return ReceiverEditResource::make($receiver);
//
//        }catch (Exception|NotFoundException $exception)
//        {
//            return apiResponse(message: $exception->getMessage(),code: 404);
//        }
//    }


    public function edit(int $id)
    {
        try {
            $withRelations = ['branch.company:id,name','addresses'=>fn($query)=>$query->with(['city','area'])];
            $receiver = $this->receiverService->findById(id: $id, withRelations: $withRelations);
            return ReceiverEditResource::make($receiver);
        }catch (Exception|NotFoundException $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 404);
        }
    }

    public function store(ReceiverStoreRequest $request)
    {
        try {
            DB::beginTransaction();
                $receiverDto = $request->toReceiverDTO();
                $this->receiverService->store($receiverDto);
            DB::commit();
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function update(ReceiverUpdateRequest $request, int $id)
    {
        try {
            $receiverDTO = $request->toReceiverDTO();
            $this->receiverService->update($id, $receiverDTO);
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
