<?php

// namespace Database\Factories\Admin;
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('en_US')->name();
        $name_en = fake('en_US')->name();

        $slug = Str::slug($name);

        return [
            'slug' => $slug,
            'name' => $name,
            'name_en' => $name_en,
            'image' => '/upload/images/lab_1.png',
            'status' => 1,
            'admin_id' => 1,
        ];
    }
}
