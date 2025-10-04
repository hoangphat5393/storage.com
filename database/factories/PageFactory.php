<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Backend\Page;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */

class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'slug' => fake()->slug(),
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraph(),
            'image' => '/upload/images/post/post1.webp',
            'type' => 'page',
            'status' => 1,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random datetime trong khoảng
            'updated_at' => now(), // Hiện tại
            'user_id' => 1,
        ];
    }
}
