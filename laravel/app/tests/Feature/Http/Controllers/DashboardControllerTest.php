<?php

use App\Models\Category;
use App\Models\Product;

use function Pest\Laravel\getJson;

it('deve retornar código 401 ao buscar a quantidade de categorias sem estar logado', function () {

    getJson(route('dashboard.countCategories'))
        ->assertStatus(401);

})->group('dashboard', 'dashboard.countCategories');

it('deve retornar código 200 ao buscar a quantidade de categorias com usuário logado', function () {

    actingAsUserApi()
        ->getJson(route('dashboard.countCategories'))
        ->assertStatus(200);

})->group('dashboard', 'dashboard.countCategories');

it('deve confirmar que existem 25 categorias ativas', function () {

    $activeCategories = Category::factory()->count(25)->activated()->create();

    Category::factory()->count(10)->inactivated()->create();

    expect(actingAsUserApi()->getJson(route('dashboard.countCategories')))
        ->content()
        ->toEqual(count($activeCategories));

})->group('dashboard', 'dashboard.countCategories');

//--------------------//

it('deve retornar código 401 ao buscar a quantidade de produtos sem estar logado', function () {

    getJson(route('dashboard.countProducts'))
        ->assertStatus(401);

})->group('dashboard', 'dashboard.countProducts');

it('deve retornar código 200 ao buscar a quantidade de produtos com usuário logado', function () {

    actingAsUserApi()
        ->getJson(route('dashboard.countProducts'))
        ->assertStatus(200);

})->group('dashboard', 'dashboard.countProducts');

it('deve confirmar que existem 25 produtos', function () {

    $activeProducts = Product::factory()->count(25)->activated()->create();

    Product::factory()->count(10)->inactivated()->create();

    expect(actingAsUserApi()->getJson(route('dashboard.countProducts')))
        ->content()
        ->toEqual(count($activeProducts));

})->group('dashboard', 'dashboard.countProducts');
