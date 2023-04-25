<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Location extends Model
{
    use HasFactory,NodeTrait;
    protected $fillable = [
        'status', 'lft' ,'rgt','title','_lft','_lft','parent_id'
    ];
}
