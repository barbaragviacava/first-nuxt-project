<?php

use function Pest\Laravel\getJson;

it('deve retornar código 401 quando tentar buscar uma categoria sem estar logado', function($categoria) {

    getJson(route('categorias.show', $categoria->id))
        ->assertStatus(401);

})->with('categoria_geralt')->group('categorias', 'categorias.show');

it('deve retornar código 200 quando tentar buscar uma categoria estando logado', function($categoria) {

    actingAsUserApi()
        ->getJson(route('categorias.show', $categoria->id))
        ->assertStatus(200);

})->with('categoria_geralt')->group('categorias', 'categorias.show');

it('deve buscar uma categoria corretamente', function($categoria) {

    expect(actingAsUserApi()
            ->getJson(route('categorias.show', $categoria->id))
            ->json()
        )->toMatchArray([
            'id' => $categoria->id,
            'nome' => $categoria->nome,
            'active' => $categoria->active,
            'categoria_pai_id' => $categoria->categoria_pai_id,
        ]);

})->with('categoria_geralt')->group('categorias', 'categorias.show');
