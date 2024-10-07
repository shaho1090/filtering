<?php

namespace App\Filters\OrderFilter;

use Illuminate\Database\Eloquent\Builder;

readonly class OrderStatusFilter
{
    public function __construct(private Builder $builder, private string $status = '')
    {
    }

    public function run(): Builder
    {
        if (empty($this->status)) {
            return $this->builder;
        }

        return $this->builder->where('status', $this->status);
    }
}
