<?php

use App\Models\Category;
use App\Repositories\CategoryRepository;

it('deve retornar código 401 ao tentar consultar as categorias sem estar logado', function () {

    $this->getJson(route('categories.index'))
        ->assertStatus(401);

})->group('categories', 'categories.index');

it('deve retornar código 200 ao tentar consultar as categorias quando logado', function () {

    actingAsUserApi()
        ->getJson(route('categories.index'))
        ->assertStatus(200);

})->group('categories', 'categories.index');

it('deve retornar um array com a estrutura [\'data\', \'meta\', \'links\'] ao consultar as categorias', function () {

    actingAsUserApi()
        ->getJson(route('categories.index'))
        ->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

})->group('categories', 'categories.index');

it('deve retornar uma lista de 15 categorias', function () {

    $activeCategories = Category::factory()->count(10)->activated()->create();
    $inactiveCategories = Category::factory()->count(5)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('categories.index'));

    expect($response['data'])
        ->toHaveLength(count($activeCategories) + count($inactiveCategories));

})->group('categories', 'categories.index');

it('deve retornar uma lista de 10 categorias quando filtrado por apenas ativas', function () {

    $activeCategories = Category::factory()->count(10)->activated()->create();
    Category::factory()->count(5)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('categories.index', ['active' => CategoryRepository::FILTER_ACTIVE_YES]));

    expect($response['data'])
        ->toHaveLength(count($activeCategories));

})->group('categories', 'categories.index', 'categories.index.filters');

it('deve retornar uma lista de 5 categorias quando filtrado por apenas inativas', function () {

    Category::factory()->count(10)->activated()->create();
    $inactiveCategories = Category::factory()->count(5)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('categories.index', ['active' => CategoryRepository::FILTER_ACTIVE_NO]));

    expect($response['data'])
        ->toHaveLength(count($inactiveCategories));

})->group('categories', 'categories.index', 'categories.index.filters');

it('deve retornar um usuário chamado "Geralt de Rivia" quando filtrado pelo nome "de r"', function () {

    $categoryName = [
        'name' => 'Geralt de Rivia',
    ];

    Category::factory()->count(1)->create($categoryName);

    $response = actingAsUserApi()
        ->getJson(route('categories.index', ['name' => 'de r']));

    expect($response['data'])
        ->toHaveLength(1)
        ->each(fn ($category) => $category->toMatchArray($categoryName));

})->group('categories', 'categories.index', 'categories.index.filters');

it('não deve retornar nenhuma categoria se filtrado por apenas ativas e não tiver nenhuma ativa', function () {

    Category::factory()->count(2)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('categories.index', ['active' => CategoryRepository::FILTER_ACTIVE_YES]));

    expect($response['data'])
        ->toHaveLength(0);

})->group('categories', 'categories.index', 'categories.index.filters');

it('deve retornar uma lista de 20 categorias (paginação)', function () {

    Category::factory()->count(30)->activated()->create();

    $response = actingAsUserApi()
        ->getJson(route('categories.index'));

    expect($response['data'])
        ->toHaveLength(CategoryRepository::PAGINATION_DEFAULT);

})->group('categories', 'categories.index', 'categories.index.pagination');
