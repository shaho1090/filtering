<?php

namespace App\Http\Controllers;

use App\Filters\OrderFilter\OrderFilter;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(OrderFilter $orderFilter): JsonResponse
    {
        $orders = Order::with(['customer'])->filter($orderFilter)
            ->orderBy(
                $orderFilter->getSortField(),
                $orderFilter->getSortDirection(),
            )->paginate($orderFilter->getPerPageCount());

        return response()->json(new OrderCollection($orders));
    }
}
