<?php

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('deve retornar código 200 ao realizar login', function () {

    postJson(route('login'), [
        'email' => $this->user->email,
        'password' => 'password',
    ])->assertStatus(200);
})->group('login');

it('deve retornar uma estrutura json específica ao realizar login', function () {

    postJson(route('login'), [
        'email' => $this->user->email,
        'password' => 'password',
    ])->assertJsonStructure([
        'access_token',
        'token_type',
        'expires_in',
    ]);
})->group('login');

it('deve retornar erro 401 quando NÃO informar o e-mail na tentativa de login', function() {

    postJson(route('login'), [
        'password' => 'password',
    ])->assertStatus(401);
})->group('login.email');

it('deve retornar erro 401 quando informar um e-mail NÃO existente na tentativa de login', function() {

    postJson(route('login'), [
        'email' => 'testeemailnaoexistente0000@teste.com',
        'password' => 'password',
    ])->assertStatus(401);
})->group('login.email');

it('deve retornar erro 401 quando NÃO informar a senha na tentativa de login', function() {

    postJson(route('login'), [
        'email' => $this->user->email,
    ])->assertStatus(401);
})->group('login.senha');

it('deve retornar erro 401 quando informar uma senha incorreta na tentativa de login', function() {

    postJson(route('login'), [
        'email' => $this->user->email,
        'password' => 'umasenhaincorreta0000',
    ])->assertStatus(401);
})->group('login.senha');

it('deve retornar código 401 para buscar informações do user logado sem ter feito login', function () {

    getJson(route('auth.user'))
        ->assertStatus(401);
})->group('api.user');

it('deve retornar código 200 para a requisição de usuário logado', function () {
    actingAsUserApi()
        ->getJson(route('auth.user'))
        ->assertStatus(200);
})->group('api.user');

it('deve retornar as informações do usuário logado', function () {
    actingAsUserApi()
        ->getJson(route('auth.user'))
        ->assertJsonStructure([
            'id',
            'name',
            'email',
        ]);
})->group('api.user');

it('deve retornar código 200 para a requisição de logout de um usuário logado', function () {
    actingAsUserApi()
        ->postJson(route('auth.logout'))
        ->assertStatus(200);
})->group('auth.logout');

it('deve retornar código 200 para a requisição de logout SEM um usuário logado', function () {

    postJson(route('auth.logout'))
        ->assertStatus(200);
})->group('auth.logout');
