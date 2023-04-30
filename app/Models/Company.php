<?php

namespace App\Models;

use App\Enums\AttachmentsType;
use App\Traits\HasAddresses;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory,HasAddresses,HasAttachment;

    protected $fillable = ['name', 'email','ceo', 'phone', 'show_dashboard', 'notes', 'status','commercial_number'];

    public function addresses(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Address::class,'addressable');
    }

    public function logo(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class,'attachmentable')->where('type',AttachmentsType::PRIMARYIMAGE->value);
    }

    public function getAddressAttribute()
    {
        return $this->relationLoaded('addresses') && isset($this->addresses) ? $this->addresses->address : null;
    }

    public function getImagePathAttribute(): string
    {
        return $this->relationLoaded('logo') && isset($this->logo) ?  asset($this->logo->path."/".$this->logo->file_name) : asset('assets/images/default_image.png');
    }

    public function branches(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Branch::class,'company_id');
    }

    public function departments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Department::class,'company_id');
    }

}
