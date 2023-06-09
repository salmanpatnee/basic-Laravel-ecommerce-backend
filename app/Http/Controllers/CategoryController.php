<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginate = request('paginate', 10);
        $term     = request('search', '');
        $sortOrder  = request('sortOrder', 'desc');
        $orderBy    = request('orderBy', 'name');

        $categories = Category::search($term)
            ->orderBy($orderBy, $sortOrder)
            ->paginate($paginate);

        return CategoryResource::collection($categories->loadCount('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $attributes = $request->validated();

        $category =  Category::create($attributes);

        return (new CategoryResource($category))
            ->additional([
                'message' => 'Category added successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $attributes = $request->validated();

        $category->update($attributes);

        return (new CategoryResource($category))
            ->additional([
                'message' => 'Category updated successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->id === 1) return;

        $category->delete();

        return response([
            'message' => 'Category deleted successfully.',
            'status'  => 'success'
        ], Response::HTTP_OK);
    }
}
