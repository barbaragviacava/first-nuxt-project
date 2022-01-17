<?php

use App\Models\Categoria;

use function Pest\Laravel\postJson;

it('deve retornar código 401 quando tentar criar uma categoria sem estar logado', function() {

    postJson(route('categorias.store'), [
        'nome' => 'Testé A\'Op',
    ])
    ->assertStatus(401);

})->group('categorias.store');

it('deve retornar código 201 quando tentar criar uma categoria estando logado', function() {

    actingAsUserApi()
        ->postJson(route('categorias.store'), [
            'nome' => 'Testé A\'Op',
        ])
        ->assertStatus(201);

})->group('categorias', 'categorias.store');

it('deve criar uma categoria com nome "Geralt de Rivia" e ativa', function() {

    $novaCategoria = [
        'nome' => 'Geralt de Rivia',
    ];

    expect(actingAsUserApi()
            ->postJson(route('categorias.store'), $novaCategoria)
            ->json()
        )->toMatchArray($novaCategoria + ['active' => true]);

})->group('categorias', 'categorias.store');

it('deve criar uma categoria com o mesmo nome de outra categoria inativa já existente', function() {

    $categoriaNova = [
        'nome' => 'Geralt de Rivia',
    ];

    Categoria::factory()->inativado()->create($categoriaNova);

    actingAsUserApi()
        ->postJson(route('categorias.store'), $categoriaNova)
        ->assertStatus(201);

})->group('categorias', 'categorias.store');

it('deve criar uma categoria relacionada à uma categoria pai', function() {

    $categoriaPai = Categoria::factory()->ativado()->create();

    actingAsUserApi()
        ->postJson(route('categorias.store'), [
            'nome' => 'Cat. Filha',
            'categoria_pai_id' => $categoriaPai->id,
        ])
        ->assertStatus(201);

})->group('categorias', 'categorias.store');

it('deve retornar código 422 se não informar o nome da categoria', function() {

    actingAsUserApi()
        ->postJson(route('categorias.store'))
        ->assertStatus(422);

})->group('categorias', 'categorias.store', 'categorias.store.validacao');

it('deve retornar código 422 se informar o nome vazio da categoria', function() {

    actingAsUserApi()
        ->postJson(route('categorias.store'), ['nome' => ''])
        ->assertStatus(422);

})->group('categorias', 'categorias.store', 'categorias.store.validacao');

it('deve retornar código 422 se informar um nome já existente de uma categoria ativa', function() {

    $categoriaNova = [
        'nome' => 'Geralt de Rivia',
    ];

    Categoria::factory()->ativado()->create($categoriaNova);

    actingAsUserApi()
        ->postJson(route('categorias.store'), $categoriaNova)
        ->assertStatus(422);

})->group('categorias', 'categorias.store', 'categorias.store.validacao');

it('deve retornar código 422 se informar o id de uma categoria pai não existente', function() {

    $categoriaNova = [
        'nome' => 'Geralt de Rivia',
        'categoria_pai_id' => 160,
    ];

    actingAsUserApi()
        ->postJson(route('categorias.store'), $categoriaNova)
        ->assertStatus(422);

})->group('categorias', 'categorias.store', 'categorias.store.validacao');
