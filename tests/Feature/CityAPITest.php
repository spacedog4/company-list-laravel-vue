<?php

use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list cities', function () {
    $expected = City::factory()->create();

    $response = $this->get('/api/cities');

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'state_id' => $expected->state_id,
                'name' => $expected->name
            ]
        ],
        'from' => 1,
        'to' => 1
    ]);
});

it('should list up to 20 cities', function () {
    City::factory(40)->create();

    $response = $this->get('/api/cities');

    $response->assertOk();

    $response->assertJson([
        'from' => 1,
        'to' => 20,
        'per_page' => 20
    ]);

    $this->assertCount(20, $response->json('data'));
});

it('can filter state by name', function() {
    $expected = City::factory()->create([
        'name' => 'expected'
    ]);
    $alsoExpected = City::factory()->create([
        'name' => 'also expected'
    ]);

    $notExpected = City::factory()->create([
        'name' => 'dont'
    ]);

    $response = $this->get('/api/cities?q=expected');

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'state_id' => $expected->state_id,
                'name' => $expected->name
            ],
            [
                'id' => $alsoExpected->id,
                'state_id' => $alsoExpected->state_id,
                'name' => $alsoExpected->name
            ],
        ],
        'from' => 1,
        'to' => 2
    ]);

    $response->assertDontSee($notExpected->name);
});

it('can filter city by uf', function() {
    $expected = City::factory()->create([
        'name' => 'expected'
    ]);
    $notExpected = City::factory()->create([
        'name' => 'dont'
    ]);

    $response = $this->get(sprintf('/api/cities?uf=%s', $expected->state->uf));

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'state_id' => $expected->state_id,
                'name' => $expected->name
            ]
        ],
        'from' => 1,
        'to' => 1
    ]);

    $response->assertDontSee($notExpected->name);
});
