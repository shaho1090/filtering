<?php

namespace App\Filters\OrderFilter;

use Illuminate\Database\Eloquent\Builder;

readonly class OrderAmountFilter
{
    public function __construct(private Builder $builder, private array $amounts =[])
    {
    }

    public function run(): Builder
    {
        if (empty($this->amounts)) {
            return $this->builder;
        }

        if(isset($this->amounts['min'])){
            $this->builder->where('amount', '>=', $this->amounts['min']);
        }

        if(isset($this->amounts['max'])){
            $this->builder->where('amount', '<=', $this->amounts['max']);
        }

        return $this->builder;
    }
}
