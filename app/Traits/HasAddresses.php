<?php

namespace App\Traits;

use App\Enums\ActivationStatus;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait HasAddresses
{

    public function addresses(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Address::class,'addressable');
    }

    public function storeAddress(array $data = [])
    {
        $address = $this->addresses()->create($data);
        $is_default = isset($data['is_default']) && $data['is_default'] != 0 ? 1:0; 
        if($address && $is_default)
                $this->setDefaultAddress(address: $address);
        return $address;
    }

    public function deleteAddresses(): int
    {
        return $this->addresses()->delete();
    }

    public function deleteCustomAddress(int $id)
    {
        $this->addresses->where('id', $id)->first()->delete();
    }

    public function updateAddress(array $data = [], int $id)
    {
        $address = $this->addresses->where('id', $id)->first();
        $address->update(Arr::except($data, 'is_default'));
        $is_default = isset($data['is_default']) && $data['is_default'] != 0 ? 1:0; 
        if($address && $is_default)
                $this->setDefaultAddress(address: $address);
        
    }

    public function setDefaultAddress(Address $address)
    {
        $defaultAddress = $this->addresses->where('is_default', ActivationStatus::ACTIVE->value)->first();
        $defaultAddress->is_default = ActivationStatus::INACTIVE;
        $defaultAddress->save();
        $address->is_default = ActivationStatus::ACTIVE;
        $address->save();
    }

    
}
