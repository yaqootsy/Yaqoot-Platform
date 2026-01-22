<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ScoutSyncOne extends Command
{
    protected $signature = 'scout:sync-one {id}';
    protected $description = 'Syncs a single model record (e.g., Product) with Scout using its ID.';

    public function handle()
    {
        $id = $this->argument('id');
        $product = Product::find($id);

        if (!$product) {
            $this->error("Product with ID {$id} not found.");
            return 1;
        }

        // تنفيذ المزامنة
        $product->searchable();

        $this->info("Product ID {$id} successfully synchronized with Scout.");
        return 0;
    }
}