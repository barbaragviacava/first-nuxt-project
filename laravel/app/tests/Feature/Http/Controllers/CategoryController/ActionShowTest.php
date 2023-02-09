<?php

it('deve retornar código 401 quando tentar buscar uma categoria sem estar logado', function($category) {

    $this->getJson(route('categories.show', $category->id))
        ->assertStatus(401);

})->with('category_geralt')->group('categories', 'categories.show');

it('deve retornar código 200 quando tentar buscar uma categoria estando logado', function($category) {

    actingAsUserApi()
        ->getJson(route('categories.show', $category->id))
        ->assertStatus(200);

})->with('category_geralt')->group('categories', 'categories.show');

it('deve buscar uma categoria corretamente', function($category) {

    expect(actingAsUserApi()
            ->getJson(route('categories.show', $category->id))
            ->json()
        )->toMatchArray([
            'id' => $category->id,
            'name' => $category->name,
            'active' => $category->active,
            'parent_category_id' => $category->parent_category_id,
        ]);

})->with('category_geralt')->group('categories', 'categories.show');
