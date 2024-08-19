<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageIds = Image::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();

        foreach ($imageIds as $imageId) {
            // Randomly select 3 to 5 tags
            $randomTagIds = collect($tagIds)->random(rand(3, 5));

            // Attach the selected tags to the image
            $image = Image::find($imageId);
            $image->tags()->attach($randomTagIds);

            foreach ($randomTagIds as $randomTagId) {
                $tag = Tag::find($randomTagId);
                $tag->increment('image_count');
            }
        }
    }
}
