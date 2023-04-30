<?php

namespace App\Services;

use App\Models\Company;
use App\QueryFilters\LocationsFilter;
use Illuminate\Database\Eloquent\Model;

class CompanyService extends BaseService
{

    public function __construct(public Company $model)
    {
    }
    public function getModel(): Model
    {
        return $this->model ;
    }

    public function companyQueryBuilder(array $filters = [],array $withRelations = [],$withCountRelations = [])
    {
        $result = $this->getQuery()->with($withRelations)->withCount($withCountRelations);
        return $result->filter(new LocationsFilter($filters));
    }

    public function listing(array $filters , array $withRelations = [],array $withCountRelations = [],$perPage = 10)
    {
        return $this->companyQueryBuilder(filters: $filters,withRelations: $withRelations,withCountRelations: $withCountRelations)->cursorPaginate($perPage);
    }


    public function getAll(array $filters = [],$withRelations = [])
    {
        return $this->companyQueryBuilder(filters: $filters,withRelations: $withRelations)->get();
    }

    public function store(array $data = [])
    {
        //store basic company information


    }


    public function status($id): bool
    {
        $company = $this->findById($id);
        $company->status = !$company->status;
        return $company->save();
    }//end of status

    public function toggleShowDashboard($id): bool
    {
        $company = $this->findById($id);
        $company->show_dashboard = !$company->show_dashboard;
        return $company->save();
    }//end of status

}
