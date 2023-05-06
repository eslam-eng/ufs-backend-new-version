<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Traits\EscapeUnicodeJson;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class Location extends Model
{
    use HasFactory,HasTranslations,NodeTrait,Filterable,EscapeUnicodeJson;
    protected $fillable = [
        'slug', 'currency_id', 'is_active', 'lft' ,'rgt','title','created_by','_lft','_lft','parent_id','shipping_cost'
    ];

    protected $table = 'locations';

    public $timestamps = false;

    public $translatable = ['title'];
}
