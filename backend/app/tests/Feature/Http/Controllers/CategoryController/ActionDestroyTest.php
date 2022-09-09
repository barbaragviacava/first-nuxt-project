<?php

use App\Models\Category;
use App\Models\Product;

it('deve retornar status 401 ao tentar remover sem estar logado', function ($category) {
    $this->delete(route('categories.destroy', $category->id))
        ->assertStatus(401);
})->with('category_geralt')->group('categories', 'categories.destroy');

it('deve retornar status 200 ao tentar remover estando logado', function ($category) {
    actingAsUserApi()
        ->delete(route('categories.destroy', $category->id))
        ->assertStatus(200);
})->with('category_geralt')->group('categories', 'categories.destroy');

it('deve retornar status 404 ao tentar consultar uma categoria que acabou de ser removida', function ($category) {
    actingAsUserApi()
        ->delete(route('categories.destroy', $category->id));

    actingAsUserApi()
        ->getJson(route('categories.show', $category->id))
        ->assertStatus(404);
})->with('category_geralt')->group('categories', 'categories.destroy');

it('deve retornar uma mensagem explicando que a categoria não pode ser excluida por ter vinculo com outras categorias', function () {

    $parentCategory = Category::factory()->create();
    Category::factory()->create([
        'parent_category_id' => $parentCategory->id,
    ]);

    $response = actingAsUserApi()
        ->deleteJson(route('categories.destroy', $parentCategory->id))
        ->json();

    expect($response)->toMatchArray([
        'message' => 'A categoria não pode ser excluida, pois existem outras categorias vinculadas à ela.',
    ]);
})->group('categories', 'categories.destroy');

it('deve retornar uma mensagem explicando que a categoria não pode ser excluida por ter vinculo com produtos', function () {

    $category = Category::factory()->create();
    Product::factory()->create([
        'category_id' => $category->id,
    ]);

    $response = actingAsUserApi()
        ->deleteJson(route('categories.destroy', $category->id))
        ->json();

    expect($response)->toMatchArray([
        'message' => 'A categoria não pode ser excluida, pois existem produtos vinculadas à ela.',
    ]);
})->group('categories', 'categories.destroy');
