<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Departments\DepartmentStoreRequest;
use App\Http\Requests\Api\Departments\DepartmentUpdateRequest;
use App\Http\Resources\DepartmentResource;
use App\Services\DepartmentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $departmentService)
    {

    }

    /**
     * get all departments
     */
    public function index(Request $request)
    {
        try {
            $filters = array_filter($request->all());
            $withRelations = ['company:id,name'];
            $departments = $this->departmentService->listing(filters: $filters, withRelations: $withRelations);
            return DepartmentResource::collection($departments);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function store(DepartmentStoreRequest $request)
    {
        try {
            DB::beginTransaction();
                $departmentDto = $request->toDepartmentDTO();
                $this->departmentService->store($departmentDto);
            DB::commit();
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    public function update(DepartmentUpdateRequest $request, int $id)
    {
        try {
            $departmentDTO = $request->toDepartmentDTO();
            $this->departmentService->update($id, $departmentDTO);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (Exception|NotFoundException $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }

    /**
     * delete existing department
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            $this->departmentService->destroy(id: $id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse(message: trans('lang.something_went_wrong'), code: 422);
        }
    }
}
