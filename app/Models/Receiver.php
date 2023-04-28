<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\HasAddresses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Receiver extends Model
{
    use HasFactory, HasAddresses, Filterable;

    protected $fillable = ['name', 'phone', 'company_id', 'branch_id', 'city_id', 'area_id', 'reference', 'title', 'notes'];

    public function address(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class,'city_id');
    }

    public function area(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class,'area_id');
    }

    public function getCompanyNameAttribute()
    {
        return $this->branch->company->name;
    }

    public function getBranchNameAttribute()
    {
        return $this->branch->name;
    }

    public function getAreaNameAttribute()
    {
        return $this->area->title;
    }

    public function getCityNameAttribute()
    {
        return $this->city->title;
    }
}
