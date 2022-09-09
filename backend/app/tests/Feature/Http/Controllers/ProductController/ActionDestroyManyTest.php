<?php

it('deve retornar o status code 401 quando tentar remover os produtos sem estar logado', function ($products)
{
    $this->postJson(route('products.destroyMany'), ['ids' => $products->pluck('id')])
        ->assertStatus(401);
})->with('active_products_list')->group('products', 'products.destroyMany');

it('deve retornar o status code 200 quando tentar remover os produtos estando logado', function ($products)
{
    actingAsUserApi()
        ->postJson(route('products.destroyMany'), ['ids' => $products->pluck('id')])
        ->assertStatus(200);
})->with('active_products_list')->group('products', 'products.destroyMany');

it('deve retornar uma lista vazia se remover todos os produtos', function ($products)
{
    actingAsUserApi()
        ->postJson(route('products.destroyMany'), ['ids' => $products->pluck('id')]);

    expect(
        actingAsUserApi()
            ->getJson(route('products.index'))
            ->json()['data']
    )->toHaveLength(0);
})->with('active_products_list')->group('products', 'products.destroyMany');

it('deve retornar apenas 1 produto se remover todos menos 1', function ($products)
{
    // Remove one
    $products->pop();

    actingAsUserApi()
        ->postJson(route('products.destroyMany'), ['ids' => $products->pluck('id')]);

    expect(
        actingAsUserApi()
            ->getJson(route('products.index'))
            ->json()['data']
    )->toHaveLength(1);
})->with('active_products_list')->group('products', 'products.destroyMany');
