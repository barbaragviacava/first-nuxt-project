<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserInicialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() > 0) {
            return;
        }

        User::factory()->create([
            'name' => 'Barbara Viacava',
            'email' => 'barbara.gviacava@gmail.com',
        ]);
    }
}
