<?php

namespace App\Http\Controllers;

use App\Events\OrderListExceptionEvent;
use App\Exceptions\OrderListException;
use App\Filters\OrderFilter\OrderFilter;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index(OrderFilter $orderFilter): JsonResponse
    {
        try {
            $orders = Order::with(['customer'])->filter($orderFilter)
                ->orderBy(
                    $orderFilter->getSortField(),
                    $orderFilter->getSortDirection(),
                )->paginate($orderFilter->getPerPageCount());

        } catch (\Throwable $throwable) {
                OrderListExceptionEvent::dispatch($throwable);

            return response()->json([
                'data' => []
            ], 422);
        }

        return response()->json(new OrderCollection($orders));
    }
}
