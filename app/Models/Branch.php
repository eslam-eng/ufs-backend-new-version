<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $fillable = ['name','company_id','city_id','area_id','phone'];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function city()
    {
        return $this->belongsTo(Location::class,'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Location::class,'area_id');
    }

}
