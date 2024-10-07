<?php

namespace Feature\Backoffice;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class OrdersListFilteringTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private string $endpoint = 'api/backoffice/orders';
    private string $method = 'get';

    private function makeCall(array $data = []): TestResponse
    {
        return $this->json(strtoupper($this->method), $this->endpoint, $data);
    }

    public function test_filter_by_status(): void
    {
        $orders = Order::factory(2)->create([
            'status' => OrderStatus::APPROVED->value,
        ]);
        Order::factory(3)->create([
            'status' => OrderStatus::REJECTED->value,
        ]);
        Order::factory(5)->create([
            'status' => OrderStatus::COMPLETED->value,
        ]);

        $response = $this->makeCall([
            'status' => OrderStatus::APPROVED->value,
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data', 2)
                ->where('data.0.id', $orders[1]->id)
                ->where('data.0.status', $orders[1]->status)
                ->where('data.0.amount', $orders[1]->amount)
                ->where('data.1.id', $orders[0]->id)
                ->where('data.1.status', $orders[0]->status)
                ->where('data.1.amount', $orders[0]->amount)
                ->has('links')
        );
    }

    public function test_filter_by_customer_mobile(): void
    {
        Order::factory(4)->create();
        $customer = Customer::factory()->create();
        $orders = Order::factory(3)->create([
            'customer_id' => $customer->id,
        ]);

        $response = $this->makeCall([
            'search_customer' => $customer->mobile,
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data', 3)
                ->where('data.0.id', $orders[2]->id)
                ->where('data.0.status', $orders[2]->status)
                ->where('data.0.amount', $orders[2]->amount)
                ->where('data.1.id', $orders[1]->id)
                ->where('data.1.status', $orders[1]->status)
                ->where('data.1.amount', $orders[1]->amount)
                ->where('data.2.id', $orders[0]->id)
                ->where('data.2.status', $orders[0]->status)
                ->where('data.2.amount', $orders[0]->amount)
                ->has('links')
        );
    }

    public function test_filter_by_customer_national_code(): void
    {
        Order::factory(10)->create();
        $customer = Customer::factory()->create();
        $orders = Order::factory(1)->create([
            'customer_id' => $customer->id,
        ]);

        $response = $this->makeCall([
            'search_customer' => $customer->national_code,
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data', 1)
                ->where('data.0.id', $orders[0]->id)
                ->where('data.0.status', $orders[0]->status)
                ->where('data.0.amount', $orders[0]->amount)
                ->has('links')
        );
    }

    public function test_filter_by_min_amount()
    {
        Order::factory(10)->create([
            'amount' => $this->faker->numberBetween(1_000, 9_000)
        ]);
        $orders = Order::factory(2)->create([
            'amount' => $this->faker->numberBetween(10_000, 100_000)
        ]);

        $response = $this->makeCall([
            'amount' => [
                'min' => $orders[0]->amount,
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data', 2)
                ->where('data.0.id', $orders[1]->id)
                ->where('data.0.status', $orders[1]->status)
                ->where('data.0.amount', $orders[1]->amount)
                ->where('data.1.id', $orders[0]->id)
                ->where('data.1.status', $orders[0]->status)
                ->where('data.1.amount', $orders[0]->amount)
                ->has('links')
        );
    }

    public function test_filter_by_max_amount()
    {
        Order::factory(10)->create([
            'amount' => $this->faker->numberBetween(10_000, 100_000)
        ]);
        $orders = Order::factory(2)->create([
            'amount' => $this->faker->numberBetween(1_000, 9_000)
        ]);

        $response = $this->makeCall([
            'amount' => [
                'max' => $orders[0]->amount,
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data', 2)
                ->where('data.0.id', $orders[1]->id)
                ->where('data.0.status', $orders[1]->status)
                ->where('data.0.amount', $orders[1]->amount)
                ->where('data.1.id', $orders[0]->id)
                ->where('data.1.status', $orders[0]->status)
                ->where('data.1.amount', $orders[0]->amount)
                ->has('links')
        );
    }

    public function test_filter_by_min_and_max_amount()
    {
        $min = 70_000;
        $max = 150_000;

        Order::factory(7)->create([
            'amount' => $this->faker->numberBetween(1_000, $min-1)
        ]);
        $orders = Order::factory(2)->create([
            'amount' => $this->faker->numberBetween($min,  $max)
        ]);
        Order::factory(10)->create([
            'amount' => $this->faker->numberBetween( $max+1, $max+100_000)
        ]);

        $response = $this->makeCall([
            'amount' => [
                'min' => $min,
                'max' => $max
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data', 2)
                ->where('data.0.id', $orders[1]->id)
                ->where('data.0.status', $orders[1]->status)
                ->where('data.0.amount', $orders[1]->amount)
                ->where('data.1.id', $orders[0]->id)
                ->where('data.1.status', $orders[0]->status)
                ->where('data.1.amount', $orders[0]->amount)
                ->has('links')
        );
    }
}
