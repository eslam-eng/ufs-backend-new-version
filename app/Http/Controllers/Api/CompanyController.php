<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Companies\CompanyStoreRequest;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService)
    {
    }

    public function index()
    {

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

    public function update(Request $request, int $id)
    {

    }

    public function destroy(int $id)
    {

    }

    public function getCompanyById(int $id)
    {

    }

}
