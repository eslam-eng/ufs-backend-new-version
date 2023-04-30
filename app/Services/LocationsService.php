<?php

namespace App\Services;

use App\Models\Location;
use App\QueryFilters\LocationsFilter;
use Illuminate\Database\Eloquent\Model;

class LocationsService extends BaseService
{

    public function __construct(public Location $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function locationQueryBuilder(array $filter = [])
    {
        return $this->getQuery()->filter(new LocationsFilter($filter));
    }


    public function getAll(array $filters = [])
    {
        return $this->locationQueryBuilder($filters)->get();
    }

    public function getLocationAncestors($id)
    {
        return $this->model->defaultOrder()->ancestorsAndSelf($id);
    }

    public function getLocationDescendants($location_id)
    {
        return $this->model->defaultOrder()->descendantsOf($location_id) ;
    }

}
