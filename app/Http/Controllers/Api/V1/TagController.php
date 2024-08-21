<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of tags with search and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get search parameters
        $search = $request->query('search');
        $imageCount = $request->query('image_count');
        $perPage = $request->query('per_page', 25);

        // Query tags with optional search
        $query = Tag::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        if ($imageCount && is_array($imageCount) && count($imageCount) === 2) {
            $query->whereBetween('image_count', [$imageCount[0], $imageCount[1]]);
        }

        // Get paginated results
        $tags = $query->paginate($perPage);

        // Return the paginated results with TagResource
        return ResponseService::success(
            TagResource::collection($tags)->response()->getData(true),
            'Tags retrieved successfully'
        );
    }

    /**
     * Store a newly created tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:tags|max:255',
            'image_count' => 'nullable|integer|min:0',
        ]);

        $tag = Tag::create($validated);

        return ResponseService::success(new TagResource($tag), 'Tag created successfully', 201);
    }

    /**
     * Display the specified tag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            return ResponseService::success(new TagResource($tag), 'Tag retrieved successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::notFound('Tag not found');
        }
    }

    /**
     * Update the specified tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $tag = Tag::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|unique:tags,name,' . $tag->id . '|max:255',
                'image_count' => 'nullable|integer|min:0',
            ]);

            $tag->update($validated);

            return ResponseService::success(new TagResource($tag), 'Tag updated successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::notFound('Tag not found');
        }
    }

    /**
     * Remove the specified tag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return ResponseService::success(null, 'Tag deleted successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::notFound('Tag not found');
        }
    }
}
