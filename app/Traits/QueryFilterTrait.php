<?php

namespace App\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait QueryFilterTrait
{
    public function scopeFilter($query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }
}
