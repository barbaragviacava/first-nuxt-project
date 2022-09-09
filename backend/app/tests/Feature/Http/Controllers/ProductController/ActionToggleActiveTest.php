<?php

it('deve retornar o status code 401 quando tentar trocar a situação do produto sem estar logado', function ($product)
{
    $this->putJson(route('products.toggleActive', $product->id))
        ->assertStatus(401);
})->with('product_geralt')->group('products', 'products.toggleActive');

it('deve retornar o status code 200 quando tentar trocar a situação do produto estando logado', function ($product)
{
    actingAsUserApi()
        ->putJson(route('products.toggleActive', $product->id))
        ->assertStatus(200);
})->with('product_geralt')->group('products', 'products.toggleActive');

it('deve retornar o produto com a situação invertida ao chamar o método show em seguida do método toggleActive', function ($product)
{
    actingAsUserApi()
        ->putJson(route('products.toggleActive', $product->id));

    expect(
        actingAsUserApi()
            ->getJson(route('products.show', $product->id))
            ->json()
    )->toMatchArray([
        'active' => (bool)(!$product->active),
    ]);
})->with('product_geralt')->group('products', 'products.toggleActive');
