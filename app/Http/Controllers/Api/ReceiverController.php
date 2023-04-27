<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReceiverStoreRequest;
use App\Http\Requests\Api\ReceiverUpdateRequest;
use App\Http\Resources\ReceiverResource;
use App\Services\ReceiverService;
use Exception;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
    //['name', 'phone', 'company_name', 'branch_name', 'branch_id', 'city_id', 'area_id', 'reference', 'title', 'notes'];

    public function __construct(private ReceiverService $receiverService)
    {

    }

    /**
     * get all receivers
     */
    public function index()
    {
        try{
            $filters       = [];
            $withRelations = [];
            $receivers = $this->receiverService->queryGet(filters: $filters, with: $withRelations);
            if(!$receivers)
                return apiResponse(message: trans('something_went_roing'), code: 422);
            return apiResponse(data: ReceiverResource::collection($receivers), message: trans('success_operation'));
        }catch(Exception $e){
            return apiResponse(message: trans('something_went_roing'), code: 422);
        }
    }
    public function store(ReceiverStoreRequest $request)
    {
        try{

            $receiver = $this->receiverService->store(data: $request->validated());
            if(!$receiver)
                return apiResponse(message: trans('lang.something_went_rong'), code: 422);
            
            return apiResponse(data: new ReceiverResource($receiver), message: trans('lang.success_operation'));
        
        }catch(Exception $e){

            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        
        }
    }

    public function update(ReceiverUpdateRequest $request, int $id)
    {
        try{

            $receiver = $this->receiverService->update(data: $request->validated(), id: $id);
            if(!$receiver)
                return apiResponse(message: trans('lang.something_went_rong'), code: 422);
            
            return apiResponse(data: new ReceiverResource($receiver), message: trans('lang.success_operation'));
        
        }catch(Exception $e){

            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        
        }
    }

    /**
     * delete existing receiver
     * @param int $id
     */
    public function destroy(int $id)
    {
        try{

            $status = $this->receiverService->destroy(id: $id);
            if(!$status)
                return apiResponse(message: trans('lang.soomething_went_rong'), code: 422);
            return apiResponse(message: trans('lang.success_operation'));

        }catch(Exception $e){

            return apiResponse(message: trans('lang.soomething_went_rong'), code: 422);
            
        }
    }
}
