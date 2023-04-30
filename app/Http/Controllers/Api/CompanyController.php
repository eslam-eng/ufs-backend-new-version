<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyStoreRequest;
use App\Http\Resources\CompaniesResource;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService)
    {
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $filters = array_filter(Arr::except($data,['paginate']),[]);
        $perPage = Arr::get($data,'paginate',10) ;
        $withCountRelations = ['branches'];
        return CompaniesResource::make($this->companyService->listing(filters: $filters, withCountRelations: $withCountRelations, perPage: $perPage));
    }

    public function store(CompanyStoreRequest $request)
    {
        dd($request->all());

    }

    public function update(Request $request, int $id)
    {

    }

    public function destroy(int $id)
    {

    }

    public function showDashboard(Request $request)
    {
        try {
            $this->companyService->toggleShowDashboard(id: $request->id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of featured

    public function status(Request $request)
    {
        try {
            $this->companyService->status(id: $request->id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status

}
