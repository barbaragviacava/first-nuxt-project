<?php

it('deve retornar código 401 ao tentar atualizar os dados do usuário sem estar logado', function () {

    $this->putJson(route('users.update'))
        ->assertStatus(401);

})->group('users', 'users.update');

it('deve retornar código 200 ao tentar atualizar os dados do usuário quando logado', function () {

    actingAsUserApi()
        ->putJson(route('users.update'))
        ->assertStatus(200);

})->group('users', 'users.update');

it('deve ser capaz de mudar os dados do usuário', function () {

    $newData = [
        'name' => 'Teste X',
        'email' => 'teste@t.com.br',
    ];

    actingAsUserApi()
        ->putJson(route('users.update'), $newData)
        ->assertStatus(200);

})->group('users', 'users.update');

it('deve retornar código 422 quando incluir um e-mail inválido para o usuário', function () {

    $newData = [
        'email' => 'teste_invalido',
    ];

    actingAsUserApi()
        ->putJson(route('users.update'), $newData)
        ->assertStatus(422);

})->group('users', 'users.update');
