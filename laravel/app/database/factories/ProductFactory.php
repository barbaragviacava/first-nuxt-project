<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

    public function definition(): array
    {
        $user_id = null;
        if (User::count() > 0) {
            $user_id = User::first()->id;
        } else {
            $user_id = User::factory()->create()->id;
        }

        $category_id = null;
        if (Category::count() > 0) {
            $category_id = Category::first()->id;
        } else {
            $category_id = Category::factory()->create()->id;
        }

        return [
            'name' => $this->faker->name(),
            'category_id' => $category_id,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'active' => $this->faker->boolean(),
            'created_by' => $user_id,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function activated()
    {
        return $this->state(fn (array $attributes) => [
                'active' => true,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactivated()
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}
