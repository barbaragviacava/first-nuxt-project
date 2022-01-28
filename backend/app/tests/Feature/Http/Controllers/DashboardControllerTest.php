<?php

use App\Models\Categoria;
use App\Models\Produto;

use function Pest\Laravel\getJson;

it('deve retornar código 401 ao buscar a quantidade de categorias sem estar logado', function () {

    getJson(route('dashboard.contarCategorias'))
        ->assertStatus(401);

})->group('dashboard', 'dashboard.contarCategorias');

it('deve retornar código 200 ao buscar a quantidade de categorias com usuário logado', function () {

    actingAsUserApi()
        ->getJson(route('dashboard.contarCategorias'))
        ->assertStatus(200);

})->group('dashboard', 'dashboard.contarCategorias');

it('deve confirmar que existem 25 categorias ativas', function () {

    $categoriasAtivas = Categoria::factory()->count(25)->ativado()->create();

    Categoria::factory()->count(10)->inativado()->create();

    expect(actingAsUserApi()->getJson(route('dashboard.contarCategorias')))
        ->content()
        ->toEqual(count($categoriasAtivas));

})->group('dashboard', 'dashboard.contarCategorias');

//--------------------//

it('deve retornar código 401 ao buscar a quantidade de produtos sem estar logado', function () {

    getJson(route('dashboard.contarProdutos'))
        ->assertStatus(401);

})->group('dashboard', 'dashboard.contarProdutos');

it('deve retornar código 200 ao buscar a quantidade de produtos com usuário logado', function () {

    actingAsUserApi()
        ->getJson(route('dashboard.contarProdutos'))
        ->assertStatus(200);

})->group('dashboard', 'dashboard.contarProdutos');

it('deve confirmar que existem 25 produtos', function () {

    $produtosAtivos = Produto::factory()->count(25)->ativado()->create();

    Produto::factory()->count(10)->inativado()->create();

    expect(actingAsUserApi()->getJson(route('dashboard.contarProdutos')))
        ->content()
        ->toEqual(count($produtosAtivos));

})->group('dashboard', 'dashboard.contarProdutos');
