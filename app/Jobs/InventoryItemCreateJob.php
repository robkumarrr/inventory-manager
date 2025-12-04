<?php

namespace App\Jobs;

use App\Models\InventoryItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class InventoryItemCreateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public InventoryItem $inventoryItem
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
