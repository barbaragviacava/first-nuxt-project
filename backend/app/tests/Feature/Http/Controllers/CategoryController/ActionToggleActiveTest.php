<?php

it('deve retornar o status code 401 quando tentar trocar a situação sem estar logado', function ($category) {
    $this->putJson(route('categories.toggleActive', $category->id))
        ->assertStatus(401);
})->with('category_geralt')->group('categories', 'categories.toggleActive');

it('deve retornar o status code 200 quando tentar trocar a situação estando logado', function ($category) {
    actingAsUserApi()
        ->putJson(route('categories.toggleActive', $category->id))
        ->assertStatus(200);
})->with('category_geralt')->group('categories', 'categories.toggleActive');

it('deve retornar a categoria com a situação invertida ao chamar o método show em seguida do método toggleActive', function ($category) {

    actingAsUserApi()
        ->putJson(route('categories.toggleActive', $category->id));

    expect(
        actingAsUserApi()
            ->getJson(route('categories.show', $category->id))
            ->json()
    )->toMatchArray([
        'active' => (bool)(!$category->active),
    ]);
})->with('category_geralt')->group('categories', 'categories.toggleActive');
