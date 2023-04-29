<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Receiver;
use App\QueryFilters\ReceiversFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ReceiverService extends BaseService
{

    public function __construct(public Receiver $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    //method for api with pagination
    public function listing(array $filters = [], $withRelations = [], $perPage = 10): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->receiverQueryBuilder(filters: $filters, withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function receiverQueryBuilder(array $filters = [], array $withRelations = []): Builder
    {
        $receivers = $this->getQuery()->with($withRelations);
        return $receivers->filter(new ReceiversFilters($filters));
    }

    /**
     * create new receiver
     * @param array $data
     * @return Model
     */
    public function store(array $data = []): Model
    {
        $receiver = $this->model->create($data);
        $addresses = Arr::get($data, 'addresses');
        $this->storeReceiverAddresses($receiver, addresses: $addresses);
        return $receiver;
    }

    /**
     * update existing receiver
     * @param array $data
     * @param int $id
     * @return Model
     * @throws NotFoundException
     */
    public function update(int $id, array $data = []): Model
    {
        $receiver = $this->findById($id);
        if (!$receiver)
            throw new NotFoundException(trans('lang.not_found'));
        $receiver->update($data);
        return $receiver;
    }

    /**
     * delete existing receiver
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function destroy(int $id): bool
    {
        $receiver = $this->findById($id);
        if (!$receiver)
            throw new NotFoundException(trans('lang.not_found'));
        $receiver->delete();
        $receiver->deleteAddresses();
        return true;
    }


    private function storeReceiverAddresses(Receiver $receiver, array $addresses = []): void
    {
        if (count($addresses))
            foreach ($addresses as $address) {
                $receiver->updateAddress(Arr::wrap($address));
            }
    }
}
