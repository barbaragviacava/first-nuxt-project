<?php

use App\Models\Categoria;
use App\Models\Produto;

use function Pest\Laravel\delete;

it('deve retornar status 401 ao tentar remover sem estar logado', function ($categoria) {
    delete(route('categorias.destroy', $categoria->id))
        ->assertStatus(401);
})->with('categoria_geralt')
  ->group('categorias', 'categorias.destroy');

it('deve retornar status 200 ao tentar remover estando logado', function ($categoria) {
    actingAsUserApi()
        ->delete(route('categorias.destroy', $categoria->id))
        ->assertStatus(200);
})->with('categoria_geralt')
  ->group('categorias', 'categorias.destroy');

it('deve retornar status 404 ao tentar consultar uma categoria que acabou de ser removida', function ($categoria) {
    actingAsUserApi()
        ->delete(route('categorias.destroy', $categoria->id));

    actingAsUserApi()
        ->getJson(route('categorias.show', $categoria->id))
        ->assertStatus(404);
})->with('categoria_geralt')
  ->group('categorias', 'categorias.destroy');

it('deve retornar uma mensagem explicando que a categoria não pode ser excluida por ter vinculo com outras categorias', function () {

    $categoriaPai = Categoria::factory()->create();
    Categoria::factory()->create([
        'categoria_pai_id' => $categoriaPai->id,
    ]);

    $resposta = actingAsUserApi()
        ->deleteJson(route('categorias.destroy', $categoriaPai->id))
        ->json();

    expect($resposta)->toMatchArray([
        'message' => 'A categoria não pode ser excluida, pois existem outras categorias vinculadas à ela.',
    ]);
})->group('categorias', 'categorias.destroy');

it('deve retornar uma mensagem explicando que a categoria não pode ser excluida por ter vinculo com produtos', function () {

    $categoria = Categoria::factory()->create();
    Produto::factory()->create([
        'categoria_id' => $categoria->id,
    ]);

    $resposta = actingAsUserApi()
        ->deleteJson(route('categorias.destroy', $categoria->id))
        ->json();

    expect($resposta)->toMatchArray([
        'message' => 'A categoria não pode ser excluida, pois existem produtos vinculadas à ela.',
    ]);
})->group('categorias', 'categorias.destroy');
