<?php

namespace App\Jobs;

use App\Models\InventoryItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class InventoryItemStoreJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $data) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Store job for InventoryItem has been dispatched...');
        $item = InventoryItem::query()->create($this->data);

        if ($item) {
            Log::info('Item has been successfully stored!');
        }
    }
}
