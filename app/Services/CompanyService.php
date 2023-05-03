<?php

namespace App\Services;

use App\DTO\Branch\BranchDTO;
use App\DTO\Company\CompanyDTO;
use App\Models\Branch;
use App\Models\Company;
use App\QueryFilters\CompaniesFilter;
use App\Services\BranchService;
use Illuminate\Support\Arr;

class CompanyService extends BaseService
{

    public function __construct(public Company $model, private BranchService $branchService)
    {
    }

    public function queryGet(array $filter = [],array $withRelations = [])
    {
        $result = $this->model->query()->with($withRelations);
        return $result->filter(new CompaniesFilter($filter));
    }


    public function getAll(array $filters = [])
    {
        return $this->queryGet($filters)->get();
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

}
