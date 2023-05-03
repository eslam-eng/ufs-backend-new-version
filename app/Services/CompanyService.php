<?php

namespace App\Services;

use App\DTO\Branch\BranchDTO;
use App\DTO\Company\CompanyDTO;
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
            $this->branchService->store(new BranchDTO(
                name: $branch['name'],
                phone: $branch['phone'],
                company_id: $company->id,
                city_id: $branch['city_id'],
                area_id: $branch['area_id'],
                address: $branch['address'],
                lat: $branch['lat'],
                lng: $branch['lng'],
                postal_code: $branch['postal_code'],
                map_url: $branch['map_url'],
                is_default: $branch['is_default'],
            ));

        }

        foreach($companyDTO->departmentsData() as $department)
            $company->departments()->create($department);
            
        return true;
    }

}
