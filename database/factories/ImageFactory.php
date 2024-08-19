<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence();
        $dt = $this->faker->dateTime()->getTimestamp();

        $category = Category::inRandomOrder()->first();
        $category->increment('image_count');

        return [
            "slug" => Str::slug($title) . '_' . $dt,
            "title" => $title,
            "description" => $this->faker->paragraph(),
            "size" => $this->faker->numberBetween(1, 5242880),
            "width" => $this->faker->numberBetween(1, 1024),
            "height" => $this->faker->numberBetween(1, 1024),
            "visit_count" => $this->faker->numberBetween(0, 10000),
            "download_count" => $this->faker->numberBetween(0, 10000),
            "category_id" => $category->id,
            "created_at" => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null),
            "updated_at" => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null)
        ];
    }
}
