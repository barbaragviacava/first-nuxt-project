<?php

use App\Models\User;
use App\Repositories\UserRepository;

it('deve retornar código 401 ao tentar atualizar o avatar do usuário sem estar logado', function () {

    $this->postJson(route('users.update.avatar'))
        ->assertStatus(401);

})->group('users', 'users.avatar');

it('deve ser capaz de mudar os dados do usuário', function () {

    $file = new \Illuminate\Http\UploadedFile(
        path: resource_path('test-files/avatar/avatar.png'),
        originalName: 'avatar.png',
        test: true
    );

    actingAsUserApi()
        ->postJson(route('users.update.avatar'), [
            'avatar' => $file,
        ])
        ->assertStatus(200);

    $user = User::find($this->user->id);

    expect(public_path($user->avatar))->toBeFile();

    UserRepository::removeOldAvatar($user);

})->group('users', 'users.avatar');

it('deve retornar código 422 quando tentar atualizar o avatar sem informar o arquivo', function () {

    actingAsUserApi()
        ->postJson(route('users.update.avatar'))
        ->assertStatus(422);

})->group('users', 'users.avatar');
