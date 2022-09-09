<?php

use App\Models\Category;

it('deve retornar código 401 quando atualizar um produto sem estar logado', function($product)
{
    $this->putJson(route('products.update', $product->id), [
        'name' => 'Teste Produto',
    ])
    ->assertStatus(401);

})->with('product_geralt')->group('products', 'products.update');

it('deve retornar código 200 quando atualizar um produto estando logado', function($product)
{
    actingAsUserApi()
        ->putJson(route('products.update', $product->id), [
            'name' => 'Teste Produto',
        ])
        ->assertStatus(200);

})->with('product_geralt')->group('products', 'products.update');

it('deve atualizar o produto com nome "Teste Produto"', function($product)
{
    $newProduct = [
        'name' => 'Teste Produto',
    ];

    expect(actingAsUserApi()
            ->putJson(route('products.update', $product->id), $newProduct)
            ->json()
        )->toMatchArray($newProduct);

})->with('product_geralt')->group('products', 'products.update');

it('deve atualizar o produto com uma categoria diferente', function($product)
{
    $category = Category::factory()->create();

    $newProduct = [
        'category_id' => $category->id,
    ];

    expect(actingAsUserApi()
            ->putJson(route('products.update', $product->id), $newProduct)
            ->json()
        )->toMatchArray($newProduct);

})->with('product_geralt')->group('products', 'products.update');

it('deve retornar código 422 se atualizar o preço como zero', function($product)
{
    actingAsUserApi()
        ->putJson(route('products.update', $product->id), [
            'price' => 0,
        ])
        ->assertStatus(422);

})->with('product_geralt')->group('products', 'products.update', 'products.update.validation');

it('deve retornar código 422 se atualizar o preço com valor negativo', function($product)
{
    actingAsUserApi()
        ->putJson(route('products.update', $product->id), [
            'price' => -1,
        ])
        ->assertStatus(422);

})->with('product_geralt')->group('products', 'products.update', 'products.update.validation');
