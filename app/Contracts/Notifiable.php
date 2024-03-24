<?php

namespace App\Contracts;
use App\Models\Api\V1\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminProductNotification;

trait Notifiable{

    public function notifyAdmin($product)
    {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            $productDetails = $this->prepareProductDetails($product);
            $admin->notify(new AdminProductNotification($productDetails));
        }
    }

    protected function prepareProductDetails($product)
    {
        $userName = $product->user->name;
        // $categoryName = $product->category->name;
        return [
            'name' => $product->name,
            'price' => $product->price,
            'status' => $product->status,
            'user_name' => $userName,
            // 'category_name' => $categoryName,
            'product_id' => $product->id,
        ];
    }

}
