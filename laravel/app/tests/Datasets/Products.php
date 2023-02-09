<?php

use App\Models\Product;

dataset('product_geralt', function () {
    yield fn() => Product::factory()->create(['name' => 'Geralt de Rivia']);
});

dataset('inactive_products_list', function () {
    yield fn() => Product::factory()->count(5)->inactivated()->create();
});

dataset('active_products_list', function () {
    yield fn() => Product::factory()->count(5)->activated()->create();
});
