<?php

use function Pest\Laravel\postJson;

it('deve retornar código 401 quando tentar criar um produto sem estar logado', function()
{
    postJson(route('products.store'), [
        'name' => 'Testé A\'Op',
    ])
    ->assertStatus(401);

})->group('products', 'products.store');

it('deve retornar código 201 quando tentar criar um produto estando logado', function($category)
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => 'Testé A\'Op',
            'price' => 50.00,
            'category_id' => $category->id,
        ])
        ->assertStatus(201);

})->with('category_geralt')->group('products', 'products.store');

it('deve criar um produto com nome "Geralt de Rivia" e ativo', function($category)
{
    $newProduct = [
        'name' => 'Geralt de Rivia',
        'price' => 100.00,
        'category_id' => $category->id,
    ];

    expect(actingAsUserApi()
            ->postJson(route('products.store'), $newProduct)
            ->json()
        )->toMatchArray($newProduct + ['active' => true]);

})->with('category_geralt')->group('products', 'products.store');

it('deve retornar código 422 se não informar o nome do produto', function($category)
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'category_id' => $category->id,
        ])
        ->assertStatus(422);

})->with('category_geralt')->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se informar o nome vazio do produto', function($category)
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => '',
            'category_id' => $category->id,
        ])
        ->assertStatus(422);

})->with('category_geralt')->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se não informar o preço do produto', function($category)
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => 'Nome do Produto',
            'category_id' => $category->id,
        ])
        ->assertStatus(422);

})->with('category_geralt')->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se informar o preço vazio do produto', function($category)
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => 'Nome do Produto',
            'price' => null,
            'category_id' => $category->id,
        ])
        ->assertStatus(422);

})->with('category_geralt')->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se informar o preço como zero', function($category)
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => 'Nome do Produto',
            'price' => 0,
            'category_id' => $category->id,
        ])
        ->assertStatus(422);

})->with('category_geralt')->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se informar o preço negativo', function($category)
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => 'Nome do Produto',
            'price' => -1,
            'category_id' => $category->id,
        ])
        ->assertStatus(422);

})->with('category_geralt')->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se não informar a categoria do produto', function()
{
    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => 'Nome Qualquer',
        ])
        ->assertStatus(422);

})->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se informar a categoria vazia do produto', function() {

    actingAsUserApi()
        ->postJson(route('products.store'), [
            'name' => 'Nome Qualquer',
            'category_id' => '',
        ])
        ->assertStatus(422);

})->group('products', 'products.store', 'products.store.validation');

it('deve retornar código 422 se informar o id de uma categoria não existente', function() {

    $newProduct = [
        'name' => 'Geralt de Rivia',
        'category_id' => 160,
    ];

    actingAsUserApi()
        ->postJson(route('products.store'), $newProduct)
        ->assertStatus(422);

})->group('products', 'products.store', 'products.store.validation');
