<?php

namespace App\Console\Commands;

use App\Models\API\V1\Product;
use Illuminate\Console\Command;
use App\Notifications\ProductDeletedNotification;

class DeleteRejectedProducts extends Command
{

    protected $signature = 'products:delete-rejected';

    protected $description = 'Delete rejected products from the database';

    public function handle()
    {
        // Define the criteria for rejected products and eager load the user relationship
        $rejectedProducts = Product::with('user')->where('status', 'rejected')->get();

        // Delete the rejected products and send notifications
        foreach ($rejectedProducts as $product) {
            $owner = $product->user;
            $productName = $product->name;

            // Send notification to the product owner
            $owner->notify(new ProductDeletedNotification($productName));

            // Delete the product
            $product->delete();
        }

        $this->info(count($rejectedProducts) . ' rejected products deleted successfully and notifications sent.');
    }
}
