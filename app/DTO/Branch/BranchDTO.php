<?php

namespace App\DTO\Branch;

use App\DTO\BaseDTO;
use Illuminate\Support\Arr;

class BranchDTO extends BaseDTO
{

    /**
     * @param int $morphable_id
     * @param int $buyer_time_type
     * @param int $day
     * @param int $time_from
     * @param int $time_to
     * @param string $morphable_type
     */

    public function __construct(
        protected string $name,
        protected string $phone,
        protected int    $company_id,
        protected ?int   $city_id,
        protected ?int   $area_id,
        protected ?string $address,
        protected ?string $lat,
        protected ?string $lng,
        protected ?string $postal_code,
        protected ?string $map_url,
        protected ?bool   $is_default,
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
            phone: $request->phone,
            company_id: $request->company_id,
            city_id: $request->city_id,
            area_id: $request->area_id,
            address: $request->address,
            lat: $request->lat,
            lng: $request->lng,
            postal_code: $request->postal_code,
            map_url: $request->map_url,
            is_default: $request->is_default
        );
    }


    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            name: Arr::get($data,'name'),
            phone: Arr::get($data,'phone'),
            company_id: Arr::get($data,'company_id'),
            city_id: Arr::get($data,'city_id'),
            area_id: Arr::get($data,'area_id'),
            address: Arr::get($data,'address'),
            lat: Arr::get($data,'lat'),
            lng: Arr::get($data,'lng'),
            postal_code: Arr::get($data,'postal'),
            map_url: Arr::get($data,'map_url'),
            is_default: Arr::get($data,'is_default')
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "phone" => $this->phone,
            "company_id" => $this->company_id,

            'city_id' => $this->city_id,
            'area_id' => $this->area_id,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'postal_code' => $this->postal_code,
            'map_url' => $this->map_url,
            'is_default' => $this->is_default

        ];
    }

    public function addressData(): array
    {
        return [

            'city_id' => $this->city_id,
            'area_id' => $this->area_id,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'postal_code' => $this->postal_code,
            'map_url' => $this->map_url,
            'is_default' => $this->is_default

        ];
    }

    public function branchData(): array
    {
        return [
            "name" => $this->name,
            "phone" => $this->phone,
            "company_id" => $this->company_id,
        ];
    }

    public static function getValidationArray(): array
    {
        return [];
    }

    public function validate(): void
    {
    }
}
