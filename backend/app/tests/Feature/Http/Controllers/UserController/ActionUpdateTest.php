<?php

use function Pest\Laravel\putJson;

it('deve retornar código 401 ao tentar atualizar os dados do usuário sem estar logado', function () {

    putJson(route('usuarios.update'))
        ->assertStatus(401);

})->group('usuarios.update');

it('deve retornar código 200 ao tentar atualizar os dados do usuário quando logado', function () {

    actingAsUserApi()
        ->putJson(route('usuarios.update'))
        ->assertStatus(200);

})->group('usuarios.update');

it('deve ser capaz de mudar os dados do usuário', function () {

    $novosDados = [
        'name' => 'Teste X',
        'email' => 'teste@t.com.br',
    ];

    actingAsUserApi()
        ->putJson(route('usuarios.update'), $novosDados)
        ->assertStatus(200);

})->group('usuarios.update');

it('deve retornar código 422 quando incluir um e-mail inválido para o usuário', function () {

    $novosDados = [
        'email' => 'teste_invalido',
    ];

    actingAsUserApi()
        ->putJson(route('usuarios.update'), $novosDados)
        ->assertStatus(422);

})->group('usuarios.update');
