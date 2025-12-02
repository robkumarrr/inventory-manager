<?php

use App\Http\Requests\InventoryItemFormRequest;
use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\Testing\AssertableInertia as Assert;

it('tests that the welcome page is loaded', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
});

it('tests the Welcome component', function() {
    $response = $this->get(route('home'));

    $response->assertInertia(fn (Assert $page) =>
        $page->component('Welcome')
    );
});

it('tests if the correct props are passed with the route', function() {
    $response = $this->get(route('home'));

    $response->assertInertia(fn (Assert $page) =>
        $page->hasAll(['inventoryItems', 'canRegister'])
    );
});

it('tests if the form is submitted with the correct fields', function()
{
    $user = User::factory()->create();

    $this->actingAs($user)->withMiddleware(['auth', 'verified']);

    $request = InventoryItemFormRequest::create(route('inventory_item.create'), 'POST', [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
        'bad_key' => 'bad_value'
    ]);

    $request->setContainer(app());
    $request->validateResolved();

    $validated = $request->validated();

    expect($validated)->toBe([
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
    ])->and($validated)->not->toHaveKey('bad_key');
});
