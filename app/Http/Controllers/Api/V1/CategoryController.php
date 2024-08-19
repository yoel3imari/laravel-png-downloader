<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\ResponseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get search parameters
        $search = $request->query('search');
        $imageCount = $request->query('image_count');
        $perPage = $request->query('per_page', 10);

        // Query categories with optional search
        $query = Category::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        if ($imageCount && is_array($imageCount) && count($imageCount) === 2) {
            $query->where($imageCount);
        }

        // Get paginated results
        $categories = $query->paginate($perPage);

        // Return the paginated results with CategoryResource
        return ResponseService::success(
            CategoryResource::collection($categories)->response()->getData(true),
            'Categories retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|unique"
        ]);

        $category = new Category([
            "name" => $request->get("name")
        ]);
        $category->save();

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return ResponseService::success(new CategoryResource($category), 'Category retrieved successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::notFound('Category not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string',
                'image_count' => 'required|integer|min:0',
            ]);

            $category->update($validated);

            return ResponseService::success(new CategoryResource($category), 'Category updated successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::notFound('Category not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return ResponseService::success(null, 'Category deleted successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::notFound('Category not found');
        }
    }
}
