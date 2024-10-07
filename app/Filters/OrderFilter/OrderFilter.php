<?php

namespace App\Filters\OrderFilter;

use App\Filters\QueryFilter;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends QueryFilter
{

    public function setModel(): void
    {
        $this->model = Order::class;
    }

    /**
     * @param string $status
     * @return Builder
     */
    public function status(string $status): Builder
    {
        return (new OrderStatusFilter($this->builder, $status))->run();
    }

    /**
     * $search term can be the customer's national code or
     * the customer's mobile phone
     *
     * @param int $searchTerm
     * @return Builder
     */
    public function searchCustomer(int $searchTerm): Builder
    {
        return (new OrderCustomerSearchFilter($this->builder, $searchTerm))->run();
    }

    /**
     * @param array $amounts
     * @return Builder
     */
    public function amount(array $amounts): Builder
    {
        return (new OrderAmountFilter($this->builder, $amounts))->run();
    }
}
