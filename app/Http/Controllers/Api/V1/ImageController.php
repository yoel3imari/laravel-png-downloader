<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class ImageController extends Controller
{
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
            'image' => 'required|mimes:png|max:5120',
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'category_id' => 'required'
        ], [
            'image.required' => 'image is required',
            'image.mimes' => 'image must be of type png',
            'image.max' => 'image must be less than 5Mb',
            'title.required' => 'title is required',
            'description.required' => 'description is required',
            'tags.required' => 'you need at least 5 tags',
            'category_id' => 'categoy is required'
        ]);

        // process image

        // check if category exist if not return error
        // $categ = Category::findOrFail($request->category_id);

        // if tag not exist create it

        return response()->json(["reQ" => $request]);

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
}
