<?php

namespace App\Services;

use App\DTO\Department\DepartmentDTO;
use App\Exceptions\NotFoundException;
use App\Models\Department;
use App\QueryFilters\DepartmentsFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DepartmentService extends BaseService
{

    public function __construct(public Department $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    //method for api with pagination
    public function listing(array $filters = [], array $withRelations = [], $perPage = 10): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->departmentQueryBuilder(filters: $filters, withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function departmentQueryBuilder(array $filters = [], array $withRelations = []): Builder
    {
        $departments = $this->getQuery()->with($withRelations);
        return $departments->filter(new DepartmentsFilters($filters));
    }

    /**
     * create new department
     * @param array $data
     * @return bool
     */
    public function store(DepartmentDTO $departmentDTO): bool
    {
        $department = $this->model->create($departmentDTO->departmentData());
        return true;
    }

    /**
     * update existing department
     * @param array $data
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function update(int $id, DepartmentDTO $departmentDTO): bool
    {
        $department = $this->findById($id);
        if (!$department)
            throw new NotFoundException(trans('lang.not_found'));
        $department->update($departmentDTO->departmentData());
        return true;
    }

    /**
     * delete existing department
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function destroy(int $id): bool
    {
        $department = $this->findById($id);
        if (!$department)
            throw new NotFoundException(trans('lang.not_found'));
        $department->delete();
        return true;
    }

}
