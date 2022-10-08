<?php

use App\Models\Company;
use Database\Seeders\CitySeeder;
use Database\Seeders\StateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed(StateSeeder::class);
    seed(CitySeeder::class);
});

it('can list companies', function () {
    $expected = Company::factory()->create();

    $response = $this->get('/api/companies');

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'city_id' => $expected->city_id,
                'name' => $expected->name,
                'description' => $expected->description,
                'email' => $expected->email,
                'phone' => $expected->phone
            ]
        ],
        'from' => 1,
        'to' => 1
    ]);
});

it('should list up to 6 companies', function () {
    Company::factory(12)->create();

    $response = $this->get('/api/companies');

    $response->assertOk();

    $response->assertJson([
        'from' => 1,
        'to' => 6,
        'per_page' => 6
    ]);

    $this->assertCount(6, $response->json('data'));
});

it('can filter company by name', function () {
    $expected = Company::factory()->create([
        'name' => 'expected'
    ]);
    $alsoExpected = Company::factory()->create([
        'name' => 'also expected'
    ]);

    $notExpected = Company::factory()->create([
        'name' => 'dont'
    ]);

    $response = $this->get('/api/companies?name=expected');

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'city_id' => $expected->city_id,
                'name' => $expected->name,
                'description' => $expected->description,
                'email' => $expected->email,
                'phone' => $expected->phone
            ],
            [
                'id' => $alsoExpected->id,
                'city_id' => $alsoExpected->city_id,
                'name' => $alsoExpected->name,
                'description' => $alsoExpected->description,
                'email' => $alsoExpected->email,
                'phone' => $alsoExpected->phone
            ],
        ],
        'from' => 1,
        'to' => 2
    ]);

    $response->assertDontSee($notExpected->name);
});

it('can filter company by uf', function () {
    $expected = Company::factory()->create([
        'name' => 'expected'
    ]);
    $notExpected = Company::factory()->create([
        'name' => 'dont'
    ]);

    $response = $this->get(sprintf('/api/companies?uf=%s', $expected->city->state->uf));

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'city_id' => $expected->city_id,
                'name' => $expected->name,
                'description' => $expected->description,
                'email' => $expected->email,
                'phone' => $expected->phone
            ]
        ],
        'from' => 1,
        'to' => 1
    ]);

    $response->assertDontSee($notExpected->name);
});


it('can filter company by city', function () {
    $expected = Company::factory()->create([
        'name' => 'expected'
    ]);
    $notExpected = Company::factory()->create([
        'name' => 'dont'
    ]);

    $response = $this->get(sprintf('/api/companies?city_id=%s', $expected->city->id));

    $response->assertOk();

    $response->assertJson([
        'current_page' => 1,
        'data' => [
            [
                'id' => $expected->id,
                'city_id' => $expected->city_id,
                'name' => $expected->name,
                'description' => $expected->description,
                'email' => $expected->email,
                'phone' => $expected->phone
            ]
        ],
        'from' => 1,
        'to' => 1
    ]);

    $response->assertDontSee($notExpected->name);
});
