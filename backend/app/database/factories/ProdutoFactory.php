<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produto::class;

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

        $categoria_id = null;
        if (Categoria::count() > 0) {
            $categoria_id = Categoria::first()->id;
        } else {
            $categoria_id = Categoria::factory()->create()->id;
        }

        return [
            'nome' => $this->faker->name(),
            'categoria_id' => $categoria_id,
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
