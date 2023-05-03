<?php

namespace App\DTO\Company;

use App\DTO\BaseDTO;
use Illuminate\Support\Arr;

class CompanyDTO extends BaseDTO
{

    public function __construct(
        protected string $name,
        protected string $email,
        protected string $ceo,
        protected string $phone,
        protected bool   $show_dashboard,
        protected string $notes,
        protected ?bool  $status,

        protected ?int    $city_id,
        protected ?int    $area_id,
        protected ?string $address,
        protected ?string $lat,
        protected ?string $lng,
        protected ?string $postal_code,
        protected ?string $map_url,
        protected ?bool   $is_default,

        protected array $branches,
        protected array $departments,
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
            email: $request->email,
            ceo: $request->ceo,
            phone: $request->phone,
            show_dashboard: $request->show_dashboard,
            notes: $request->notes,
            status: $request->status,

            city_id: $request->city_id,
            area_id: $request->area_id,
            address: $request->address,
            lat: $request->lat,
            lng: $request->lng,
            postal_code: $request->postal_code,
            map_url: $request->map_url,
            is_default: $request->is_default,
            
            branches: $request->branches,
            departments: $request->departments,
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
            email: Arr::get($data,'email'),
            ceo: Arr::get($data,'ceo'),
            phone: Arr::get($data,'phone'),
            show_dashboard: Arr::get($data,'show_dashboard'),
            notes: Arr::get($data,'notes'),
            status: Arr::get($data,'status'),

            city_id: Arr::get($data,'city_id'),
            area_id: Arr::get($data,'area_id'),
            address: Arr::get($data,'address'),
            lat: Arr::get($data,'lat'),
            lng: Arr::get($data,'lng'),
            postal_code: Arr::get($data,'postal_code'),
            map_url: Arr::get($data,'map_url'),
            is_default: Arr::get($data,'is_default'),
            
            branches: Arr::get($data,'branches'),
            departments: Arr::get($data,'departments'),

        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'=> $this->name,
            'email'=> $this->email,
            'ceo'=> $this->ceo,
            'phone'=> $this->phone,
            'show_dashboard'=> $this->show_dashboard,
            'notes'=> $this->notes,
            'status'=> $this->status,

            'city_id'=> $this->city_id,
            'area_id'=> $this->area_id,
            'address'=> $this->address,
            'lat'=> $this->lat,
            'lng'=> $this->lng,
            'postal_code'=> $this->postal_code,
            'map_url'=> $this->map_url,
            'is_default'=> $this->is_default,
            
            'branches'=> $this->branches,
            'departments'=> $this->departments,
        ];
    }

    public function addressData(): array
    {
        return [

            'city_id'=> $this->city_id,
            'area_id'=> $this->area_id,
            'address'=> $this->address,
            'lat'=> $this->lat,
            'lng'=> $this->lng,
            'postal_code'=> $this->postal_code,
            'map_url'=> $this->map_url,
            'is_default'=> $this->is_default,

        ];
    }

    public function companyData(): array
    {
        return [
            'name'=> $this->name,
            'email'=> $this->email,
            'ceo'=> $this->ceo,
            'phone'=> $this->phone,
            'show_dashboard'=> $this->show_dashboard,
            'notes'=> $this->notes,
            'status'=> $this->status,
        ];
    }

    public function branchesData(): array
    {

        $data = [];
        for($i = 0; $i < count($this->branches); $i++)
        {
            $data[$i] = [
                'name' => $this->branches[$i]['name'],
                'phone' => $this->branches[$i]['phone'],
                'city_id' => $this->branches[$i]['city_id'],
                'area_id' => $this->branches[$i]['area_id'],
                'address' => $this->branches[$i]['address'],
                'lat' => $this->branches[$i]['lat'],
                'lng' => $this->branches[$i]['lng'],
                'postal' => $this->branches[$i]['postal_code'],
                'map_url' => $this->branches[$i]['map_url'],
                'is_default' => true,
            ];
        }
        return $data;
    }

    public function departmentsData(): array
    {

        $data = [];
        for($i = 0; $i < count($this->departments); $i++)
        {
            $data[$i] = [
                'name' => $this->departments[$i]['name'],
            ];
        }
        return $data;
    }

    public static function getValidationArray(): array
    {
        return [];
    }

    public function validate(): void
    {
    }
}
