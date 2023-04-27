<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Receiver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReceiverService extends BaseService
{

    public function queryGet(array $filters = [], array $with = [])
    {
        return Receiver::with($with)->get();
    }

    /**
     * create new receiver
     * @param array $data
     * @return Model
     */
    public function store(array $data = []): Model
    {
        return Receiver::create($data);
    }

    /**
     * update existing receiver
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function update(array $data = [], int $id): Model
    {
        $receiver = Receiver::find($id);
        $receiver->update($data);
        return $receiver;
    }

    /**
     * delete existing receiver
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $receiver = Receiver::find($id);
        $receiver->delete();
        return true;
    }
}
