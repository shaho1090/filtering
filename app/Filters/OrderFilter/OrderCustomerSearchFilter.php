<?php

namespace App\Filters\OrderFilter;

use Illuminate\Database\Eloquent\Builder;

readonly class OrderCustomerSearchFilter
{
    public function __construct(private Builder $builder, private ?int $searchTerm = null)
    {
    }

    public function run(): Builder
    {
        if (empty($this->searchTerm)) {
            return $this->builder;
        }

        return $this->builder->whereHas('customer',
            fn (Builder $query) => $query->where('mobile', $this->searchTerm)
                ->orWhere('national_code', $this->searchTerm)
        );
    }
}
