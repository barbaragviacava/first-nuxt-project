<?php

use App\Models\Categoria;

use function Pest\Laravel\putJson;

it('deve retornar código 401 quando atualizar um produto sem estar logado', function($produto) {

    putJson(route('produtos.update', $produto->id), [
        'nome' => 'Teste Produto',
    ])
    ->assertStatus(401);

})->with('produto_geralt')->group('produtos', 'produtos.update');

it('deve retornar código 200 quando atualizar um produto estando logado', function($produto) {

    actingAsUserApi()
        ->putJson(route('produtos.update', $produto->id), [
            'nome' => 'Teste Produto',
        ])
        ->assertStatus(200);

})->with('produto_geralt')->group('produtos', 'produtos.update');

it('deve atualizar o produto com nome "Teste Produto"', function($produto) {

    $novoProduto = [
        'nome' => 'Teste Produto',
    ];

    expect(actingAsUserApi()
            ->putJson(route('produtos.update', $produto->id), $novoProduto)
            ->json()
        )->toMatchArray($novoProduto);

})->with('produto_geralt')->group('produtos', 'produtos.update');

it('deve atualizar o produto com uma categoria diferente', function($produto) {

    $categoria = Categoria::factory()->create();

    $novoProduto = [
        'categoria_id' => $categoria->id,
    ];

    expect(actingAsUserApi()
            ->putJson(route('produtos.update', $produto->id), $novoProduto)
            ->json()
        )->toMatchArray($novoProduto);

})->with('produto_geralt')->group('produtos', 'produtos.update');
