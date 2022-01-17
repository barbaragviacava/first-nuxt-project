<?php

use App\Models\Categoria;

use function Pest\Laravel\putJson;

it('deve retornar código 401 quando atualizar uma categoria sem estar logado', function($categoria) {

    putJson(route('categorias.update', $categoria->id), [
        'nome' => 'Teste Categoria',
    ])
    ->assertStatus(401);

})->with('categoria_geralt')->group('categorias', 'categorias.update');

it('deve retornar código 200 quando atualizar uma categoria estando logado', function($categoria) {

    actingAsUserApi()
        ->putJson(route('categorias.update', $categoria->id), [
            'nome' => 'Teste Categoria',
        ])
        ->assertStatus(200);

})->with('categoria_geralt')->group('categorias', 'categorias.update');

it('deve atualizar a categoria com nome "Teste Categoria"', function($categoria) {

    $novaCategoria = [
        'nome' => 'Teste Categoria',
    ];

    expect(actingAsUserApi()
            ->putJson(route('categorias.update', $categoria->id), $novaCategoria)
            ->json()
        )->toMatchArray($novaCategoria);

})->with('categoria_geralt')->group('categorias', 'categorias.update');

it('deve atualizar a categoria com o mesmo nome de outra categoria inativa já existente', function($categoria) {

    $dadosAtualizar = [
        'nome' => 'Pode nome igual? Não se estiver ativa',
    ];

    Categoria::factory()->inativado()->create($dadosAtualizar);

    actingAsUserApi()
        ->putJson(route('categorias.update', $categoria->id), $dadosAtualizar)
        ->assertStatus(200);

})->with('categoria_geralt')->group('categorias', 'categorias.update');

it('deve atualizar relacionar a categoria à uma categoria pai com sucesso', function($categoria) {

    $categoriaPai = Categoria::factory()->ativado()->create();

    actingAsUserApi()
        ->putJson(route('categorias.update', $categoria->id), [
            'nome' => 'Cat. Filha',
            'categoria_pai_id' => $categoriaPai->id,
        ])
        ->assertStatus(200);

})->with('categoria_geralt')->group('categorias', 'categorias.update');

it('deve retornar código 422 se não informar o nome da categoria', function($categoria) {

    actingAsUserApi()
        ->putJson(route('categorias.update', $categoria->id))
        ->assertStatus(422);

})->with('categoria_geralt')->group('categorias', 'categorias.update', 'categorias.update.validacao');

it('deve retornar código 422 se informar o nome vazio da categoria', function($categoria) {

    actingAsUserApi()
        ->putJson(route('categorias.update', $categoria->id), ['nome' => ''])
        ->assertStatus(422);

})->with('categoria_geralt')->group('categorias', 'categorias.update', 'categorias.update.validacao');

it('deve retornar código 422 se informar um nome já existente de uma categoria ativa', function($categoria) {

    $dadosAtualizar = [
        'nome' => 'Teste Categoria',
        'active' => true,
    ];

    Categoria::factory()->ativado()->create($dadosAtualizar);

    actingAsUserApi()
        ->putJson(route('categorias.update', $categoria->id), $dadosAtualizar)
        ->assertStatus(422);

})->with('categoria_geralt')->group('categorias', 'categorias.update', 'categorias.update.validacao');

it('deve retornar código 422 se informar o id de uma categoria pai não existente', function($categoria) {

    $dadosAtualizar = [
        'nome' => 'Nome',
        'categoria_pai_id' => 160,
    ];

    actingAsUserApi()
        ->putJson(route('categorias.update', $categoria->id), $dadosAtualizar)
        ->assertStatus(422);

})->with('categoria_geralt')->group('categorias', 'categorias.update', 'categorias.update.validacao');
