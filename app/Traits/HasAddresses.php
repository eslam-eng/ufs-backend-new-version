<?php

namespace App\Traits;
use App\Models\Address;
use Illuminate\Support\Arr;

trait HasAddresses
{

    public function addresses()
    {
        return $this->morphMany(Address::class,'addressable');
    }

    public function storeAddress($data=[])
    {
        return $this->addresses()->create($data);
    }

    public function updateAddress($data=[])
    {
        $this->addresses->each(function ($address){
            $address->delete();
        });
        $this->storeAddress($data);
    }

    public function deleteAddresses()
    {

        $this->addresses()->each(function ($address){
           $address->delete();
        });

    }

}
