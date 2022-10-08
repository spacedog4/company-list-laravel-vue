<?php

use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list states', function () {
    $expectedState = State::factory()->create();

    $response = $this->get('/api/states');

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expectedState->id,
                'name' => $expectedState->name,
                'uf' => $expectedState->uf
            ]
        ],
        'from' => 1,
        'to' => 1
    ]);
});

it('should list up to 20 states', function () {
    State::factory(40)->create();

    $response = $this->get('/api/states');

    $response->assertOk();

    $response->assertJson([
        'from' => 1,
        'to' => 20,
        'per_page' => 20
    ]);

    $this->assertCount(20, $response->json('data'));
});

it('can filter state by name', function() {
    $expected = State::factory()->create([
        'name' => 'expected'
    ]);
    $alsoExpected = State::factory()->create([
        'name' => 'also expected'
    ]);

    $notExpected = State::factory()->create([
        'name' => 'dont'
    ]);

    $response = $this->get('/api/states?q=expected');

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'name' => $expected->name,
                'uf' => $expected->uf
            ],
            [
                'id' => $alsoExpected->id,
                'name' => $alsoExpected->name,
                'uf' => $alsoExpected->uf
            ],
        ],
        'from' => 1,
        'to' => 2
    ]);

    $response->assertDontSee($notExpected->name);
});
