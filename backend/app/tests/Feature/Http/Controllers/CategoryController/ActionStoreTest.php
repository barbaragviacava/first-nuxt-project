<?php

use App\Models\Category;

it('deve retornar código 401 quando tentar criar uma categoria sem estar logado', function() {

    $this->postJson(route('categories.store'), [
        'name' => 'Testé A\'Op',
    ])
    ->assertStatus(401);

})->group('categories', 'categories.store');

it('deve retornar código 201 quando tentar criar uma categoria estando logado', function() {

    actingAsUserApi()
        ->postJson(route('categories.store'), [
            'name' => 'Testé A\'Op',
        ])
        ->assertStatus(201);

})->group('categories', 'categories.store');

it('deve criar uma categoria com nome "Geralt de Rivia" e ativa', function() {

    $newCategory = [
        'name' => 'Geralt de Rivia',
    ];

    expect(actingAsUserApi()
            ->postJson(route('categories.store'), $newCategory)
            ->json()
        )->toMatchArray($newCategory + ['active' => true]);

})->group('categories', 'categories.store');

it('deve criar uma categoria com o mesmo nome de outra categoria inativa já existente', function() {

    $newCategory = [
        'name' => 'Geralt de Rivia',
    ];

    Category::factory()->inactivated()->create($newCategory);

    actingAsUserApi()
        ->postJson(route('categories.store'), $newCategory)
        ->assertStatus(201);

})->group('categories', 'categories.store');

it('deve criar uma categoria relacionada à uma categoria pai', function() {

    $parentCategory = Category::factory()->activated()->create();

    actingAsUserApi()
        ->postJson(route('categories.store'), [
            'name' => 'Cat. Filha',
            'parent_category_id' => $parentCategory->id,
        ])
        ->assertStatus(201);

})->group('categories', 'categories.store');

it('deve retornar código 422 se não informar o nome da categoria', function() {

    actingAsUserApi()
        ->postJson(route('categories.store'))
        ->assertStatus(422);

})->group('categories', 'categories.store', 'categories.store.validation');

it('deve retornar código 422 se informar o nome vazio da categoria', function() {

    actingAsUserApi()
        ->postJson(route('categories.store'), ['name' => ''])
        ->assertStatus(422);

})->group('categories', 'categories.store', 'categories.store.validation');

it('deve retornar código 422 se informar um nome já existente de uma categoria ativa', function() {

    $newCategory = [
        'name' => 'Geralt de Rivia',
    ];

    Category::factory()->activated()->create($newCategory);

    actingAsUserApi()
        ->postJson(route('categories.store'), $newCategory)
        ->assertStatus(422);

})->group('categories', 'categories.store', 'categories.store.validation');

it('deve retornar código 422 se informar o id de uma categoria pai não existente', function() {

    $newCategory = [
        'name' => 'Geralt de Rivia',
        'parent_category_id' => 160,
    ];

    actingAsUserApi()
        ->postJson(route('categories.store'), $newCategory)
        ->assertStatus(422);

})->group('categories', 'categories.store', 'categories.store.validation');
