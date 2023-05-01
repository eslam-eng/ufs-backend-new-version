<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Address\AddressStoreRequest;
use App\Http\Requests\Api\Address\AddressStoreRequest as AddressUpdateRequest;
use App\Http\Resources\AddressResource;
use App\Services\AddressService;
use Exception;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(private AddressService $addressService)
    {

    }

    /**
     * get all addresses
     * @param Request $request
     */
    public function index(Request $request)
    {
        try {
            $filters = array_filter($request->all());
            $withRelations = ['city', 'area'];
            $addresses = $this->addressService->listing(filters: $filters, withRelations: $withRelations);
            return AddressResource::collection($addresses);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: $e->getCode());
        }
    }

    /**
     * create new address
     * @param AddressStoreRequest $request
     */
    public function store(AddressStoreRequest $request)
    {
        try {
            $this->addressService->store(data: $request->validated());
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    /**
     * update existing address
     * @param AddressUpdateRequest $request
     * @param int $id //address id
     */
    public function update(AddressUpdateRequest $request, int $id)
    {
        try {
            $this->addressService->update(data: $request->validated(), id: $id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }
    }

    /**
     * delete existing address
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            $this->addressService->destroy(id: $id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }
}
