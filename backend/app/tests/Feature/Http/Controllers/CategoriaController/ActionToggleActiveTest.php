<?php

use function Pest\Laravel\putJson;

it('deve retornar o status code 401 quando tentar trocar a situação sem estar logado', function ($categoria) {
    putJson(route('categorias.toggleActive', $categoria->id))
        ->assertStatus(401);
})->with('categoria_geralt')
  ->group('categorias', 'categorias.toggleActive');

it('deve retornar o status code 200 quando tentar trocar a situação estando logado', function ($categoria) {
    actingAsUserApi()
        ->putJson(route('categorias.toggleActive', $categoria->id))
        ->assertStatus(200);
})->with('categoria_geralt')
  ->group('categorias', 'categorias.toggleActive');

it('deve retornar a categoria com a situação invertida ao chamar o método show em seguida do método toggleActive', function ($categoria) {

    actingAsUserApi()
        ->putJson(route('categorias.toggleActive', $categoria->id));

    expect(
        actingAsUserApi()
            ->getJson(route('categorias.show', $categoria->id))
            ->json()
    )->toMatchArray([
        'active' => (bool)(!$categoria->active),
    ]);
})->with('categoria_geralt')
  ->group('categorias', 'categorias.toggleActive');
