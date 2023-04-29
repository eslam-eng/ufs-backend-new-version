<?php

namespace App\Traits;
use App\Models\Address;
use Illuminate\Support\Arr;

trait HasAddresses
{

    public function addresses(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Address::class,'addressable');
    }

    public function storeAddress(array $data = [])
    {
        return $this->addresses()->create($data);
    }

    public function deleteAddresses()
    {

        $this->addresses()->each(function ($address){
           $address->delete();
        });

    }

}
