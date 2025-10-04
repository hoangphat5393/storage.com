<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlbumItem>
 */
class AlbumItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('vi_VN')->name(),
            'name_en' => fake('en_US')->name(),
            'image' => '/upload/images/image1.webp',
            'image_en' => '/upload/images/image1.webp',
            'description' => fake()->sentence(6),
            'description_en' => fake()->sentence(6),
            'link' => fake('vi_VN')->name(),
            'link_en' => fake('en_US')->name(),
            'link_name' => fake('vi_VN')->name(),
            'link_name_en' => fake('en_US')->name(),
            'target' => '_blank',
            'admin_id' => 1
        ];
    }
}
