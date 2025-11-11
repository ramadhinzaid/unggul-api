<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_customers()
    {
        Customer::factory()->count(5)->create();

        $response = $this->get('/api/customers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status_code',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'domicile',
                    'gender',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_show_a_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->get('/api/customers/' . $customer->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status_code',
            'message',
            'data' => [
                'id',
                'name',
                'domicile',
                'gender',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /** @test */
    public function it_can_create_a_customer()
    {
        $data = [
            'name' => 'John Doe',
            'domicile' => 'New York',
            'gender' => 'male',
        ];

        $response = $this->postJson('/api/customers', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status_code',
            'message',
            'data' => [
                'id',
                'name',
                'domicile',
                'gender',
                'created_at',
                'updated_at',
            ]
        ]);
        $this->assertDatabaseHas('customers', $data);
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        $customer = Customer::factory()->create();
        $data = [
            'name' => 'Jane Doe',
            'domicile' => 'London',
            'gender' => 'female',
        ];

        $response = $this->putJson('/api/customers/' . $customer->id, $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status_code',
            'message',
            'data' => [
                'id',
                'name',
                'domicile',
                'gender',
                'created_at',
                'updated_at',
            ]
        ]);
        $this->assertDatabaseHas('customers', $data);
    }

    /** @test */
    public function it_can_delete_a_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->delete('/api/customers/' . $customer->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
