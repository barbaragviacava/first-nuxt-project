<?php

use App\Models\Category;

dataset('category_geralt', function () {
    yield fn() => Category::factory()->create(['name' => 'Geralt de Rivia']);
});

dataset('category_with_child', function () {
    yield fn() => Category::factory()->activated()->create([
        'name' => 'Geralt Filho de Rivia',
        'parent_category_id' => Category::factory()->activated()->create(['name' => 'Geralt de Rivia'])->id
    ]);
});
