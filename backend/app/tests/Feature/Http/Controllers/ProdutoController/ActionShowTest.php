<?php

use function Pest\Laravel\getJson;

it('deve retornar código 401 quando tentar buscar um produto sem estar logado', function($produto) {

    getJson(route('produtos.show', $produto->id))
        ->assertStatus(401);

})->with('produto_geralt')->group('produtos', 'produtos.show');

it('deve retornar código 200 quando tentar buscar um produto estando logado', function($produto) {

    actingAsUserApi()
        ->getJson(route('produtos.show', $produto->id))
        ->assertStatus(200);

})->with('produto_geralt')->group('produtos', 'produtos.show');

it('deve buscar um produto corretamente', function($produto) {

    expect(actingAsUserApi()
            ->getJson(route('produtos.show', $produto->id))
            ->json()
        )->toMatchArray([
            'id' => $produto->id,
            'nome' => $produto->nome,
            'categoria_id' => $produto->categoria_id,
            'active' => $produto->active,
        ]);

})->with('produto_geralt')->group('produtos', 'produtos.show');
