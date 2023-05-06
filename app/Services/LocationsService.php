<?php

namespace App\Services;

use App\Models\Location;
use App\QueryFilters\LocationsFilter;

class LocationsService extends BaseService
{

    public function __construct(public Location $model)
    {
    }

    public function queryGet(array $filter = [])
    {
        $result = $this->model->query();
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
        return $this->model->defaultOrder()->descendantsOf($location_id) ;
    }

    
    /**
     * @param array $locationData
     * @return mixed
     */
    public function store(array $locationData = []): mixed
    {
        $locationData['is_active'] = isset($locationData['is_active'])  ?  1 :  0;
        return Location::create($locationData);
    }

    /**
     * @param int $id
     * @param array $locationData
     * @return false
     */
    public function update(int $id,array $locationData): bool
    {
        $location = Location::find($id);
        $data['is_active'] = isset($locationData['is_active'])  ?  1 :  0;

        if ($location)
            return $location->update($locationData);
        return false;
    }

    public function delete($id): bool
    {
        $location = Location::find($id);
        if ($location)
            return $location->delete();
        return false;
    }
    
}
