<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can display home page', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});
