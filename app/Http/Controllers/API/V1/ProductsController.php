<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\{Images,Responses,Notifiable};
use App\Models\API\V1\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\ProductStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Products\{
    StoreProductRequest,
    UpdateProductRequest,
    ProductStatusRequest,
};

class ProductsController extends Controller
{
    use Images,Responses,Notifiable;

    public function index(Request $request)
    {
        if ($request->hasAny(['sort_by_date', 'sort_by_name', 'sort_by_price', 'filter_by_status', 'sort_by_category_name','sort_by_product_count'])) {
            return (new FilterController())->filterProducts($request);
        }

        return $this->indexOrShowResponse('products', Product::all());
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);
        return DB::transaction(function() use ($request) {
            $request_images = $request->images;
            $images = $this->setImagesName($request_images);
            $product = Product::create($request->all());
            $product->createManyImages($images);
            $this->saveImages($request_images, $images, 'Product');
            // $this->notifyAdmin($product);
            return $this->sudResponse('The product added successfully, please wait to accept it by admin.', 201);
        });
    }

    public function show(Product $product)
    {
        $this->authorize('view', Product::class);
        return $this->indexOrShowResponse('product', $product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', Product::class);
        return DB::transaction(function() use ($request, $product) {

            $product->update($request->all());

            if($request->hasFile('images')) {

                $request_images = $request->images;
                $current_images = $product->images()->pluck('image_name')->toArray();
                $images = $this->setImagesName($request_images);
                $product->images()->delete();
                $product->createManyImages($images);
                $this->saveImages($request_images, $images, 'Product');
                $this->deleteImages('Product', $current_images);
            }

            return $this->sudResponse('Product Updated Successfully');
        });
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', Product::class);
        return DB::transaction(function() use ($product) {
            $current_images = $product->images()->pluck('image_name')->toArray();
            $product->images()->delete();
            $product->delete();
            $this->deleteImages('Product', $current_images);
            return $this->sudResponse('Product Deleted Successfully');
        });
    }

    public function updateStatus(ProductStatusRequest $request,Product $product)
    {
        $this->authorize('update', Product::class);
        $status = $request->status;
        $product->forceFill([
            'status' => $request->status,
        ])->save();
        $this->notifyUser($product, $status);
    }

    protected function notifyUser($product, $status)
    {
        $user = $product->user;
        Mail::to($user)->send(new ProductStatusMail($product, $status));
    }


}
