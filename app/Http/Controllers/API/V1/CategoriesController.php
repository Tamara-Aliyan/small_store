<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Images;
use App\Contracts\Responses;
use Illuminate\Http\Request;
use App\Models\API\V1\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\V1\Categories\{
    StoreCategoryRequest,
    UpdateCategoryRequest
};

class CategoriesController extends Controller
{
    use Images,Responses;

    public function index(Request $request)
    {
        if ($request->hasAny(['sort_by_date', 'sort_by_name', 'sort_by_products_number'])) {
            return (new FilterController())->filterCategories($request);
        }

        $categories = Category::with(['childrens', 'products.user'])->parent()->get();
        return $this->indexOrShowResponse('categories', $categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        return DB::transaction(function() use ($request) {
            $request_image = $request->image;
            $image = $this->setImagesName([$request_image])[0];
            $category = Category::create($request->all());
            $category->images()->create(['image_name' => $image]);
            $this->saveImages([$request_image], [$image], 'Category');
            return $this->sudResponse('Category Created Successfully', 201);
        });
    }

    public function show(Category $category)
    {
        $this->authorize('view', Category::class);
        $category = $category->load(['childrens', 'products.user']);
        return $this->indexOrShowResponse('category', $category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', Category::class);
        return DB::transaction(function() use ($request, $category) {

            $category->update($request->all());

            if($request->hasFile('image')) {

                $request_image = $request->image;
                $current_images = $category->images()->pluck('image_name')->toArray();
                $image = $this->setImagesName([$request_image])[0];
                $category->images()->update(['image_name' => $image]);
                $this->saveImages([$request_image], [$image], 'Category');
                $this->deleteImages('Category', $current_images);

            }

            return $this->sudResponse('Category Updated Successfully');
        });
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', Category::class);
        return DB::transaction(function() use ($category) {
            $current_images = $category->images()->pluck('image_name')->toArray();
            $category->images()->delete();
            $category->delete();
            $this->deleteImages('Category', $current_images);
            return $this->sudResponse('Category Deleted Successfully');
        });
    }
}
