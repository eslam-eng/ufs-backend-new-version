<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Companies\CompanyStoreRequest;
use App\Http\Requests\Api\Companies\CompanyUpdateRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService)
    {
    }

    public function index(Request $request)
    {
        try {
            $filters = array_filter($request->all());
            $withRelations = ['defaultAddress'];
            $companies = $this->companyService->listing(filters: $filters, withRelations: $withRelations);
            return CompanyResource::collection($companies);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: $e->getCode());
        }
    }

    public function create()
    {

    }

    public function store(CompanyStoreRequest $request)
    {
        try {
            DB::beginTransaction();
                $receiverDto = $request->toCompanyDTO();
                $this->companyService->store($receiverDto);
                
            DB::commit();
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function edit(int $id)
    {

    }

    public function update(CompanyUpdateRequest $request, int $id)
    {
        try {
            $companyDTO = $request->toCompanyDTO();
            $this->companyService->update($id, $companyDTO);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->companyService->destroy(id: $id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function getCompanyById(int $id)
    {

    }

}
