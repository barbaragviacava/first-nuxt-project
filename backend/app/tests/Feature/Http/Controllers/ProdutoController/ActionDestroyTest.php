<?php

use function Pest\Laravel\delete;

it('deve retornar status 401 ao tentar remover o produto sem estar logado', function ($produto) {
    delete(route('produtos.destroy', $produto->id))
        ->assertStatus(401);
})->with('produto_geralt')
  ->group('produtos', 'produtos.destroy');

it('deve retornar status 200 ao tentar remover o produto estando logado', function ($produto) {
    actingAsUserApi()
        ->delete(route('produtos.destroy', $produto->id))
        ->assertStatus(200);
})->with('produto_geralt')
  ->group('produtos', 'produtos.destroy');

it('deve retornar status 404 ao tentar consultar um produto que acabou de ser removido', function ($produto) {
    actingAsUserApi()
        ->delete(route('produtos.destroy', $produto->id));

    actingAsUserApi()
        ->getJson(route('produtos.show', $produto->id))
        ->assertStatus(404);
})->with('produto_geralt')
  ->group('produtos', 'produtos.destroy');
