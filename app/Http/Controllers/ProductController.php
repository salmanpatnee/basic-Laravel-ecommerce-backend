<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginate = request('paginate', 10);
        $term     = request('search', '');
        $category     = request('category', '');
        $sortOrder  = request('sortOrder', 'desc');
        $orderBy    = request('orderBy', 'name');

        $products = Product::search($term)
            ->with(['category'])
            ->orderBy($orderBy, $sortOrder)
            ->when($category, function($query, $category) {
                return $query->where('category_id', $category);
            })->paginate($paginate);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $attributes = $request->validated();

        $product =  Product::create($attributes);

        return (new ProductResource($product))
            ->additional([
                'message' => 'Product added successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $attributes = $request->validated();

        $product->update($attributes);

        return (new ProductResource($product))
            ->additional([
                'message' => 'Product updated successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response([
            'message' => 'Product deleted successfully.',
            'status'  => 'success'
        ], Response::HTTP_OK);
    }
}
