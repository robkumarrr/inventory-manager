<?php

use App\Http\Requests\InventoryItemCreateRequest;
use App\Jobs\InventoryItemStoreJob;
use App\Jobs\InventoryItemUpdateJob;
use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('tests that the welcome page is loaded', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
});

it('tests the Welcome component', function () {
    $response = $this->get(route('home'));

    $response->assertInertia(fn(Assert $page) => $page->hasAll(['canRegister'])
    );
});

it('tests if the correct props are passed with the route', function () {
    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn(Assert $page) => $page->hasAll(['inventoryItems'])
    );
});
