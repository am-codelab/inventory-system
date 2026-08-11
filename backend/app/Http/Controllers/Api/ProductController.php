<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\http\Resources\ProductResource;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(IndexProductRequest $request)
    {
        $filters = $request->validated();

        $products = Product::query()
            ->with('category')
            ->search($filters['search'] ?? null)
            ->category($filters['category_id'] ?? null)
            ->active($filters['active'] ?? null)
            ->lowStock($filters['low_stock'] ?? null)
            ->sort(
                $filters['sort'] ?? 'name',
                $filters['direction'] ?? 'asc'
            )
            ->paginate(
                $filters['per_page'] ?? 10
            )
            ->withQueryString();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->service->create($request->validated());

        $product->load('category');

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->service->update($product, $request->validated());

        $product->load('category');

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->service->delete($product);

        return response()->noContent();
    }
}
