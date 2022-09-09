<?php

use App\Models\Category;

dataset('category_geralt', function () {
    yield fn() => Category::factory()->create(['name' => 'Geralt de Rivia']);
});
