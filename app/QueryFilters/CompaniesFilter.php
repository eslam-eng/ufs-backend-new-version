<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class CompaniesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function status($term)
    {
        return $this->builder->where('status',$term);
    }
}
