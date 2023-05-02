<?php

namespace App\Services;

use App\DTO\Address\AddressDTO;
use App\Exceptions\NotFoundException;
use App\Models\Address;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use App\Models\Receiver;
use App\QueryFilters\AddressesFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AddressService extends BaseService
{

    public function __construct(public Address $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    //method for api with pagination
    public function listing(array $filters = [], $withRelations = [], $perPage = 10): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->addressQueryBuilder(filters: $filters, withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function addressQueryBuilder(array $filters = [], array $withRelations = []): Builder
    {
        $addresses = $this->getQuery()->with($withRelations);
        return $addresses->filter(new AddressesFilters($filters));
    }

    /**
     * create new address
     * @param array $data
     * @return bool
     */
    public function store(AddressDTO $addressDto): bool
    {
        $model = match ((int)$addressDto['addressable_type']) {
            Address::RECEIVER   => Receiver::find($addressDto['addressable_id']),
            Address::COMPANY    => Company::find($addressDto['addressable_id']),
            Address::BRANCH     => Branch::find($addressDto['addressable_id']),
            Address::DEPARTMENT => Department::find($addressDto['addressable_id']),
        };
        if (isset($model))
            $model->storeAddress($addressDto->addressData());    
        return true;
    }

    /**
     * update existing address
     * @param array $data
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function update(int $id, array $data = []): bool
    {
        $address = $this->getModel()->find($id);
        if (!$address)
            throw new NotFoundException(trans('lang.not_found'));
        $model = match ((int)$data['addressable_type']) {
            Address::RECEIVER   => Receiver::find($data['addressable_id']),
            Address::COMPANY    => Company::find($data['addressable_id']),
            Address::BRANCH     => Branch::find($data['addressable_id']),
            Address::DEPARTMENT => Department::find($data['addressable_id']),
        };
        if (isset($model))
            $model->updateAddress(Arr::except($data, ['addressable_type', 'addressable_id']), $id);
        return true;
    }

    /**
     * delete existing address
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function destroy(int $id): bool
    {
        $address = $this->getModel()->find($id);
        if (!$address)
            throw new NotFoundException(trans('lang.not_found'));
        $address->delete();
        return true;
    }

}
