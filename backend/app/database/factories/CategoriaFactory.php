<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Categoria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = null;
        if (User::count() > 0) {
            $user_id = User::first()->id;
        } else {
            $user_id = User::factory()->create()->id;
        }

        return [
            'nome' => $this->faker->name(),
            'active' => $this->faker->boolean(),
            'created_by' => $user_id,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function ativado()
    {
        return $this->state(function (array $attributes) {
            return [
                'active' => true,
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inativado()
    {
        return $this->state(function (array $attributes) {
            return [
                'active' => false,
            ];
        });
    }
}
