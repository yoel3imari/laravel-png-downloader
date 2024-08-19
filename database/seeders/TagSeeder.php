<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            "Adventure",
            "Animals",
            "Art",
            "Beauty",
            "Business",
            "Children",
            "City Life",
            "Comedy",
            "Cooking",
            "Design",
            "Education",
            "Entertainment",
            "Fashion",
            "Fitness",
            "Food",
            "Gardening",
            "Health",
            "History",
            "Home Decor",
            "Illustration",
            "Industry",
            "Innovation",
            "Lifestyle",
            "Music",
            "Nature",
            "Parenting",
            "Pets",
            "Photography",
            "Politics",
            "Quotes",
            "Religion",
            "Science",
            "Sports",
            "Technology",
            "Travel",
            "Urban",
            "Vintage",
            "Wellness",
            "Wedding",
            "Work",
            "Yoga",
            "Adventure Travel",
            "Artistic",
            "Business Meetings",
            "Children's Activities",
            "Cultural Events",
            "Design Trends",
            "Food Recipes",
            "Health Tips",
            "Interior Design",
            "Music Festivals",
            "Outdoor Activities",
            "Productivity",
            "Social Media",
            "Street Photography",
            "Travel Destinations",
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                "name" => $tag,
                "image_count" => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
