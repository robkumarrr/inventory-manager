<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class InventoryItemController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index() {

        Log::info('Returning InventoryItemController index');

        return Inertia::render('Welcome', [
            'inventoryItems' => InventoryItem::all(),
            'canRegister' => fn() => !auth()->user()
        ]);
    }
}
