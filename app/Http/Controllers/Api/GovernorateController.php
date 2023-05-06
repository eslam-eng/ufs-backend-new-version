<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\Location\StoreLocationRequest;
use App\Services\LocationsService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationsResource;
use Exception;

class GovernorateController extends Controller
{

    public function __construct(private LocationsService $locationsService)
    {

    }

    public function index(Request $request)
    {
        try {
            $request = $request->merge(['depth'=>1,'is_active'=>$request->is_active??1]);
            $locations = $this->locationsService->getAll(filters: $request->all());
            return LocationsResource::collection($locations);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 442);
        }
    }

    public function store(StoreLocationRequest $request)
    {
        try {
            // $addressDTO = $request->toAddressDTO();
            $this->locationsService->store($request->all());
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function update($id, StoreLocationRequest $request)
    {
        try {
            $this->locationsService->update($id, $request->all());
            return apiResponse(message: trans('lang.success_operation'));
        }catch (Exception $exception)
        {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function destroy($id)
    {
        try {
            $result =  $this->locationsService->delete($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success'));

        }catch (Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 422);
        }
    }

    public function show($id)
    {

    }
}
