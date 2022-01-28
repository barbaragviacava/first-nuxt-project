<?php

use function Pest\Laravel\putJson;

it('deve retornar o status code 401 quando tentar trocar a situação do produto sem estar logado', function ($produto) {
    putJson(route('produtos.toggleActive', $produto->id))
        ->assertStatus(401);
})->with('produto_geralt')
  ->group('produtos', 'produtos.toggleActive');

it('deve retornar o status code 200 quando tentar trocar a situação do produto estando logado', function ($produto) {
    actingAsUserApi()
        ->putJson(route('produtos.toggleActive', $produto->id))
        ->assertStatus(200);
})->with('produto_geralt')
  ->group('produtos', 'produtos.toggleActive');

it('deve retornar o produto com a situação invertida ao chamar o método show em seguida do método toggleActive', function ($produto) {

    actingAsUserApi()
        ->putJson(route('produtos.toggleActive', $produto->id));

    expect(
        actingAsUserApi()
            ->getJson(route('produtos.show', $produto->id))
            ->json()
    )->toMatchArray([
        'active' => (bool)(!$produto->active),
    ]);
})->with('produto_geralt')
  ->group('produtos', 'produtos.toggleActive');
