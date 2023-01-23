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

it('deve retornar a categoria pai e filha com a situação invertida ao chamar o método show em seguida do método toggleActive', function ($category) {

    actingAsUserApi()
        ->putJson(route('categories.toggleActive', $category->parent_category_id));

    $expected = (bool)(!$category->active);

    expect(
        actingAsUserApi()
            ->getJson(route('categories.show', $category->id))
            ->json()
    )->toMatchArray([
        'active' => $expected
    ])->parentCategory->toMatchArray([
        'active' => $expected
    ]);
})->with('category_with_child')->group('categories', 'categories.toggleActive');
