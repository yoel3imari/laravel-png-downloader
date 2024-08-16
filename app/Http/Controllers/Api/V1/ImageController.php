<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\ImageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // search with query params return up to 50 jpeg images
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        //------- process image -------//
        $pngImage = $request->file('image');
        $output = $this->imageService->handleImageUpload($pngImage, $title);

        return response()->json(["message" => "Image added successfully", "image" => $output]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return jpeg image with details and related images
        // maybe use a Recommendation system based on tags and users activities (people also likes)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update images infos
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete image
    }

    /**
     * Download png image
     */
    public function download(string $slug) {
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
