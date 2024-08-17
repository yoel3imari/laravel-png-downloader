<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagService
{
    /**
     * Process a string of comma-separated tags.
     *
     * @param string $tagsString
     * @return array
     */
    public function processTags(string $tagsString): array
    {
        // Split the string into individual tags
        $tags = array_map('trim', explode(',', $tagsString));

        // Result array to store the IDs of the tags
        $tagIds = [];

        foreach ($tags as $tagName) {
            // Convert tag to lowercase
            $tagName = Str::lower($tagName);

            // Use a transaction to ensure atomicity
            DB::transaction(function () use ($tagName, &$tagIds) {
                // Find the tag or create a new one
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['image_count' => 1]
                );

                // If the tag already existed, increment the image_count
                if (!$tag->wasRecentlyCreated) {
                    $tag->increment('image_count');
                }

                // Add the tag ID to the result array
                $tagIds[] = $tag->id;
            });
        }

        return $tagIds;
    }
}
