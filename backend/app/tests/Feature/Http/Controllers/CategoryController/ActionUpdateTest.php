<?php

use App\Models\Category;

it('deve retornar código 401 quando atualizar uma categoria sem estar logado', function($category) {

    $this->putJson(route('categories.update', $category->id), [
        'name' => 'Teste Categoria',
    ])
    ->assertStatus(401);

})->with('category_geralt')->group('categories', 'categories.update');

it('deve retornar código 200 quando atualizar uma categoria estando logado', function($category) {

    actingAsUserApi()
        ->putJson(route('categories.update', $category->id), [
            'name' => 'Teste Categoria',
        ])
        ->assertStatus(200);

})->with('category_geralt')->group('categories', 'categories.update');

it('deve atualizar a categoria com nome "Teste Categoria"', function($category) {

    $newCategory = [
        'name' => 'Teste Categoria',
    ];

    expect(actingAsUserApi()
            ->putJson(route('categories.update', $category->id), $newCategory)
            ->json()
        )->toMatchArray($newCategory);

})->with('category_geralt')->group('categories', 'categories.update');

it('deve atualizar a categoria com o mesmo nome de outra categoria inativa já existente', function($category) {

    $updateData = [
        'name' => 'Pode nome igual? Não se estiver ativa',
    ];

    Category::factory()->inactivated()->create($updateData);

    actingAsUserApi()
        ->putJson(route('categories.update', $category->id), $updateData)
        ->assertStatus(200);

})->with('category_geralt')->group('categories', 'categories.update');

it('deve relacionar a categoria à uma categoria pai com sucesso', function($category) {

    $parentCategory = Category::factory()->activated()->create();

    actingAsUserApi()
        ->putJson(route('categories.update', $category->id), [
            'name' => 'Cat. Filha',
            'parent_category_id' => $parentCategory->id,
        ])
        ->assertStatus(200);

})->with('category_geralt')->group('categories', 'categories.update');

it('deve retornar código 422 se não informar o nome da categoria', function($category) {

    actingAsUserApi()
        ->putJson(route('categories.update', $category->id))
        ->assertStatus(422);

})->with('category_geralt')->group('categories', 'categories.update', 'categories.update.validation');

it('deve retornar código 422 se informar o nome vazio da categoria', function($category) {

    actingAsUserApi()
        ->putJson(route('categories.update', $category->id), ['name' => ''])
        ->assertStatus(422);

})->with('category_geralt')->group('categories', 'categories.update', 'categories.update.validation');

it('deve retornar código 422 se informar um nome já existente de uma categoria ativa', function($category) {

    $updateData = [
        'name' => 'Teste Categoria',
        'active' => true,
    ];

    Category::factory()->activated()->create($updateData);

    actingAsUserApi()
        ->putJson(route('categories.update', $category->id), $updateData)
        ->assertStatus(422);

})->with('category_geralt')->group('categories', 'categories.update', 'categories.update.validation');

it('deve retornar código 422 se informar o id de uma categoria pai não existente', function($category) {

    $updateData = [
        'name' => 'Name',
        'parent_category_id' => 160,
    ];

    actingAsUserApi()
        ->putJson(route('categories.update', $category->id), $updateData)
        ->assertStatus(422);

})->with('category_geralt')->group('categories', 'categories.update', 'categories.update.validation');
