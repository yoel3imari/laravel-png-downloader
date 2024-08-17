<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function handleImageUpload($image, $title)
    {
// Generate a unique filename using the slugified title and current timestamp
        $slug = Str::slug($title);
        $timestamp = now()->timestamp;
        $fileName = "{$slug}_{$timestamp}";

// Define paths for storing images
        $pngPath = "app/images/png/{$fileName}.png";
        $jpegPath = storage_path("/app/public/images/jpeg/original/{$fileName}.jpg");
        $bgImagePath = storage_path('app/images/bg.jpg');

// Store the original PNG file
        $image->storeAs('images/png', $fileName . '.png');

// Create the PNG image instance using Intervention/Image
        $pngImage = Image::make($image->getRealPath());

// Load the background image
        $bgImage = Image::make($bgImagePath);

// Resize the background image to match the PNG dimensions (or vice versa, as needed)
        $bgImage->resize($pngImage->width(), $pngImage->height());

// Insert the PNG image on top of the background
        $bgImage->insert($pngImage, 'center');

// Save the resulting image as a JPEG in the desired location
        //Storage::put($jpegPath, $bgImage->encode('jpg', 90));
        $bgImage->save($jpegPath, 90, 'jpg');

// Return paths or other relevant information if needed
        return [
            'slug' => $fileName,
            'size' => $pngImage->filesize(),
            'width' => $pngImage->width(),
            'height' => $pngImage->height(),
        ];
    }
}
