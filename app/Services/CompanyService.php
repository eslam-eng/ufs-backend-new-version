<?php

namespace App\Services;

use App\DTO\Branch\BranchDTO;
use App\DTO\Company\CompanyDTO;
use App\Exceptions\NotFoundException;
use App\Models\Company;
use App\QueryFilters\CompaniesFilter;
use App\Services\BranchService;
use Illuminate\Database\Eloquent\Builder;


class CompanyService extends BaseService
{

    public function __construct(public Company $model, private BranchService $branchService)
    {
    }

    public function queryGet(array $filter = [],array $withRelations = []): builder
    {
        $result = $this->model->query()->with($withRelations);
        return $result->filter(new CompaniesFilter($filter));
    }


    public function listing(array $filters = [], $withRelations  = [], $perPage = 10): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet($filters)->cursorPaginate($perPage);
    }

    /**
     * create new receiver
     * @param array $data
     * @return bool
     */
    public function store(CompanyDTO $companyDTO): bool
    {
        $company = $this->model->create($companyDTO->companyData());
        $company->storeAddress($companyDTO->addressData());
        foreach($companyDTO->branchesData() as $branch)
        {
            $branch['company_id'] = $company->id;
            $this->branchService->store(BranchDTO::fromArray(data: $branch));
        }

        foreach($companyDTO->departmentsData() as $department)
            $company->departments()->create($department);
            
        return true;
    }

    /**
     * update existing company
     * @param array $data
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function update(int $id, CompanyDTO $companyDTO): bool
    {
        $company = Company::find($id);
        if (!$company)
            throw new NotFoundException(trans('lang.not_found'));
        $company->update($companyDTO->companyData());
        return true;
    }

    /**
     * delete existing company
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function destroy(int $id): bool
    {
        $company = Company::find($id);
        if (!$company)
            throw new NotFoundException(trans('lang.not_found'));
        $company->delete();
        $company->deleteAddresses();
        return true;
    }

}
