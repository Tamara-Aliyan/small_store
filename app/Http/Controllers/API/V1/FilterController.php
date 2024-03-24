<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\API\V1\{User,Category,Product};

class FilterController extends Controller
{
    public function filterUsers(Request $request)
    {
        $query = User::query();

        // Sorting
        if ($request->has('sort_by_date')) {
            $query->orderBy('created_at', $request->sort_by_date);
        }
        if ($request->has('sort_by_name')) {
            $query->orderBy('name', $request->sort_by_name);
        }
        if ($request->has('sort_by_products_number')) {
            $query->withCount('products')->orderBy('products_count', $request->sort_by_products_number);
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $users = $query->paginate($perPage);

        return $users;
    }

    public function filterProducts(Request $request)
    {
        $query = Product::query();

        // Sorting
        if ($request->has('sort_by_date')) {
            $query->orderBy('created_at', $request->sort_by_date);
        }
        if ($request->has('sort_by_name')) {
            $query->orderBy('name', $request->sort_by_name);
        }
        if ($request->has('sort_by_price')) {
            $query->orderBy('price', $request->sort_by_price);
        }

        // Filtering by status
        if ($request->has('filter_by_status')) {
            $status = $request->filter_by_status;
            $query->where('status', $status);
        }

        // Joining categories for sorting by category name
        if ($request->has('sort_by_category_name')) {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                ->orderBy('categories.name', $request->sort_by_category_name);
        }

        // Joining and sorting by product count
        if ($request->has('sort_by_product_count')) {
            $order = $request->sort_by_product_count == 'asc' ? 'asc' : 'desc';
            $query->select('products.*')
                ->leftJoin(DB::raw('(select category_id, count(*) as product_count from products group by category_id) as category_counts'),
                    'products.category_id', '=',
                    'category_counts.category_id')
                ->orderBy('category_counts.product_count', $order);
        }

        // Filtering by price
        $query->where('price', '>=', 150);

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $products = $query->paginate($perPage);

        return response()->json($products);
    }

    public function filterCategories(Request $request)
    {
        $query = Category::query();

        // Sorting
        if ($request->has('sort_by_date')) {
            $query->orderBy('created_at', $request->sort_by_date);
        }
        if ($request->has('sort_by_name')) {
            $query->orderBy('name', $request->sort_by_name);
        }
        if ($request->has('sort_by_products_number')) {
            $query->withCount('products')->orderBy('products_count', $request->sort_by_products_number);
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $categories = $query->paginate($perPage);

        return $categories;
    }
}
