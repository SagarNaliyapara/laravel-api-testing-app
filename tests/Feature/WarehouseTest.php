<?php

namespace Tests\Feature;

use App\Models\Warehouse;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
    public function test_warehouse_list_endpoint()
    {
        Warehouse::factory()->create([
            'name' => 'test warehouse',
        ]);

        $this->getJson(route('warehouses.index'))
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'test warehouse',
                    ],
                ]
            ]);
    }

    public function test_warehouse_create_endpoint()
    {
        $response = $this->postJson(route('warehouses.store'), [
            'name' => 'New warehouse',
        ])
            ->assertStatus(201)
            ->assertJson([
                'name' => 'New warehouse',
            ]);

        $this->assertDatabaseHas('warehouses', [
            'id' => $response->json('id'),
            'name' => 'New warehouse',
        ]);
    }

    /**
     * @dataProvider createValidations
     */
    public function test_warehouse_create_endpoint_validations($name, $code)
    {
        Warehouse::factory()->create([
            'name' => 'test',
        ]);
        $response = $this->postJson(route('warehouses.store'), [
            'name' => $name,
        ])
            ->assertStatus($code);

        if ($code === 422) {
            $response->assertJsonValidationErrors(['name']);
        }
    }

    public function createValidations()
    {
        return [
            ['', 422],
            ['a', 422],
            ['aa', 201],
            ['aaaspfhsa asfasfo', 201],
            ['test', 422],
            [str_repeat("a",256), 422],
            [str_repeat("a",255), 201],
        ];
    }

    public function test_detail_warehouse_endpoint()
    {
        $warehouse = Warehouse::factory()->create();
        $this->getJson(route('warehouses.show', ['warehouse' => $warehouse->id]))
            ->assertStatus(200);
    }
}
