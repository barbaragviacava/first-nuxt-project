<?php

use function Pest\Laravel\postJson;

it('deve retornar código 401 quando tentar criar um produto sem estar logado', function() {

    postJson(route('produtos.store'), [
        'nome' => 'Testé A\'Op',
    ])
    ->assertStatus(401);

})->group('produtos.store');

it('deve retornar código 201 quando tentar criar um produto estando logado', function($categoria) {

    actingAsUserApi()
        ->postJson(route('produtos.store'), [
            'nome' => 'Testé A\'Op',
            'categoria_id' => $categoria->id,
        ])
        ->assertStatus(201);

})->with('categoria_geralt')->group('produtos', 'produtos.store');

it('deve criar um produto com nome "Geralt de Rivia" e ativo', function($categoria) {

    $novoProduto = [
        'nome' => 'Geralt de Rivia',
        'categoria_id' => $categoria->id,
    ];

    expect(actingAsUserApi()
            ->postJson(route('produtos.store'), $novoProduto)
            ->json()
        )->toMatchArray($novoProduto + ['active' => true]);

})->with('categoria_geralt')->group('produtos', 'produtos.store');

it('deve retornar código 422 se não informar o nome do produto', function($categoria) {

    actingAsUserApi()
        ->postJson(route('produtos.store'), [
            'categoria_id' => $categoria->id,
        ])
        ->assertStatus(422);

})->with('categoria_geralt')->group('produtos', 'produtos.store', 'produtos.store.validacao');

it('deve retornar código 422 se informar o nome vazio do produto', function($categoria) {

    actingAsUserApi()
        ->postJson(route('produtos.store'), [
            'nome' => '',
            'categoria_id' => $categoria->id,
        ])
        ->assertStatus(422);

})->with('categoria_geralt')->group('produtos', 'produtos.store', 'produtos.store.validacao');

it('deve retornar código 422 se não informar a categoria do produto', function() {

    actingAsUserApi()
        ->postJson(route('produtos.store'), [
            'nome' => 'Nome Qualquer',
        ])
        ->assertStatus(422);

})->group('produtos', 'produtos.store', 'produtos.store.validacao');

it('deve retornar código 422 se informar a categoria vazia do produto', function() {

    actingAsUserApi()
        ->postJson(route('produtos.store'), [
            'nome' => 'Nome Qualquer',
            'categoria_id' => '',
        ])
        ->assertStatus(422);

})->group('produtos', 'produtos.store', 'produtos.store.validacao');

it('deve retornar código 422 se informar o id de uma categoria não existente', function() {

    $produtoNovo = [
        'nome' => 'Geralt de Rivia',
        'categoria_id' => 160,
    ];

    actingAsUserApi()
        ->postJson(route('produtos.store'), $produtoNovo)
        ->assertStatus(422);

})->group('produtos', 'produtos.store', 'produtos.store.validacao');
