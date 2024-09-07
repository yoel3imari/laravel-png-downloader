<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ImageResource;
use App\Http\Resources\SearchResource;
use App\Models\Image;
use App\Services\ImageService;
use App\Services\ResponseService;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    protected ImageService $imageService;
    protected TagService $tagService;

    public function __construct(ImageService $imageService, TagService $tagService)
    {
        $this->imageService = $imageService;
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        // search with query params return up to 50 jpeg images
        $search = $request->get('search');
        $tags = $request->get('tags');
        $categories = $request->get('categories');
        $per_page = $request->get('per_page');

        $query = Image::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if (!empty($tags)) {
            $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('id', $tags);
            });
        }

        if (!empty($categories)) {
            $query->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('id', $categories);
            });
        }

        $images = $query->paginate($per_page);

        return ResponseService::success(SearchResource::collection($images)->response()->getData(true));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // validate png image
        // convert to jpeg
        // store both png and jpeg
        $validation = $request->validate([
            'image' => 'required|image|mimes:png|max:5120',
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'category' => 'required'
        ], [
            'image.required' => 'image is required',
            'image.mimes' => 'image must be of type png',
            'image.max' => 'image must be less than 5Mb',
            'title.required' => 'title is required',
            'description.required' => 'description is required',
            'tags.required' => 'you need at least 5 tags',
            'category.required' => 'categoy is required'
        ]);

        $title = trim($request->input('title'));
        $description = trim($request->input('description'));

        //------- process image -------//
        $pngImage = $request->file('image');
        [
            'slug' => $slug,
            'size' => $size,
            'width' => $width,
            'height' => $height
        ] = $this->imageService->handleImageUpload($pngImage, $title);
//        $result = $this->imageService->handleImageUpload($pngImage, $title);

        //------- process tags -------//
        $tagsId = $this->tagService->processTags($request->input('tags'));

        //------- process category -------//
        /*TODO: fix categories*/
        $category = Category::inRandomOrder()->first();

        //------- create image model -------//
        $image = new Image([
            'slug' => $slug,
            'title' => $title,
            'description' => $description,
            'size' => $size,
            'width' => $width,
            'height' => $height,
            'category_id' => $category->id,
        ]);
        $image->save();

        //------- link image tags -------//
        $image->tags()->attach($tagsId);

        return response()->json(["message" => "Image added successfully", "slug" => $slug]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return jpeg image with details and related images
        $image = Image::find($id);

        if (empty($image)) {
            return ResponseService::notFound("Image not found");
        }
        // maybe use a Recommendation system based on tags and users activities (people also likes)
        return ResponseService::success(new ImageResource($image));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        return response()->json("coming soon");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete image
        return response()->json("coming soon");
    }

    /**
     * Download png image
     */
    public function download(string $slug)
    {
//        // Define the path to the PNG image
//        $path = storage_path('app/images/png/' . $slug);
//
//        // Check if the file exists
//        if (!file_exists($path)) {
//            abort(404);
//        }
//
//        // Return the image as a downloadable response
//        return Response::download($path);
    }
}
