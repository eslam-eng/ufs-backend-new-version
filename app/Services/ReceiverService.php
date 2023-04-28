<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Receiver;
use App\QueryFilters\ReceiversFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ReceiverService extends BaseService
{

    public function __construct(private Receiver $model)
    {
        
    }

    //method for api with pagination
    public function listing(array $whereConditions = [],$withRelations = [],$perPage=10)
    {
        return $this->receiverQueryBuilder(whereConditions: $whereConditions, withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function receiverQueryBuilder(array $whereConditions = [],array $withRelations = []): Builder
    { 
        $recevers = $this->model->query()->with($withRelations);
        return $recevers->filter(new ReceiversFilters($whereConditions));
    }

    /**
     * create new receiver
     * @param array $data
     * @return Model
     */
    public function store(array $data = []): Model
    {
        $receiver = $this->model->create($data);
        if(isset($data['addresses']))
            foreach($data['addresses'] as $address)
            {
                $receiver->storeAddress(Arr::wrap($address));
            }
        return $receiver;
    }

    /**
     * update existing receiver
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function update(array $data = [], int $id): Model
    {
        $receiver = $this->model->find($id);
        $receiver->update($data);
        if(isset($data['addresses']))
            foreach($data['addresses'] as $address)
            {
                $receiver->updateAddress(Arr::wrap($address));
            }
        return $receiver;
    }

    /**
     * delete existing receiver
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $receiver = $this->model->find($id);
        $receiver->delete();
        $receiver->deleteAddresses();
        return true;
    }
}
