<?php

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

it('tests if the form is submitted with the correct fields', function() {

});
