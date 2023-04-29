<?php

namespace App\Services;

use App\Models\Company;
use App\QueryFilters\LocationsFilter;

class CompanyService extends BaseService
{

    public function __construct(public Company $model)
    {
    }

    public function queryGet(array $filter = [],array $withRelations = [])
    {
        $result = $this->model->query()->with($withRelations);
        return $result->filter(new LocationsFilter($filter));
    }


    public function getAll(array $filters = [])
    {
        return $this->queryGet($filters)->get();
    }

    public function getLocationAncestors($id)
    {
        return $this->model->defaultOrder()->ancestorsAndSelf($id);
    }

    public function getLocationDescendants($location_id)
    {
        return $this->model->defaultOrder()->descendantsOf($location_id);
    }

}
