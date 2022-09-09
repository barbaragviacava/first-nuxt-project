<?php

it('deve retornar código 401 quando tentar buscar um produto sem estar logado', function($product) {

    $this->getJson(route('products.show', $product->id))
        ->assertStatus(401);

})->with('product_geralt')->group('products', 'products.show');

it('deve retornar código 200 quando tentar buscar um produto estando logado', function($product) {

    actingAsUserApi()
        ->getJson(route('products.show', $product->id))
        ->assertStatus(200);

})->with('product_geralt')->group('products', 'products.show');

it('deve buscar um produto corretamente', function($product) {

    expect(actingAsUserApi()
            ->getJson(route('products.show', $product->id))
            ->json()
        )->toMatchArray([
            'id' => $product->id,
            'name' => $product->name,
            'category_id' => $product->category_id,
            'active' => $product->active,
        ]);

})->with('product_geralt')->group('products', 'products.show');
