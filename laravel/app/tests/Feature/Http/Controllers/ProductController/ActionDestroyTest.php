<?php

it('deve retornar status 401 ao tentar remover o produto sem estar logado', function ($product) {
    $this->delete(route('products.destroy', $product->id))
        ->assertStatus(401);
})->with('product_geralt')->group('products', 'products.destroy');

it('deve retornar status 200 ao tentar remover o produto estando logado', function ($product) {
    actingAsUserApi()
        ->delete(route('products.destroy', $product->id))
        ->assertStatus(200);
})->with('product_geralt')->group('products', 'products.destroy');

it('deve retornar status 404 ao tentar consultar um produto que acabou de ser removido', function ($product) {
    actingAsUserApi()
        ->delete(route('products.destroy', $product->id));

    actingAsUserApi()
        ->getJson(route('products.show', $product->id))
        ->assertStatus(404);
})->with('product_geralt')->group('products', 'products.destroy');
