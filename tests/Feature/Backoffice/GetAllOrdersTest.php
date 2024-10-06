<?php

namespace Feature\Backoffice;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetAllOrdersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_getting_all_orders(): void
    {
        $orders = Order::factory(2)->create();

        $response = $this->getJson('api/backoffice/orders');

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data', 2)
                ->where('data.0.id', $orders[0]->id)
                ->where('data.0.status', $orders[0]->status)
                ->where('data.0.amount', $orders[0]->amount)
                ->where('data.1.id', $orders[1]->id)
                ->where('data.1.status', $orders[1]->status)
                ->where('data.1.amount', $orders[1]->amount)
                ->has('links')
        );
    }
}
