<?php

use App\Models\Product;

it('deve retornar o status code 401 quando tentar ativar os produtos sem estar logado', function ($products)
{
    $this->postJson(route('products.activeMany'), ['ids' => $products->pluck('id')])
        ->assertStatus(401);
})->with('inactive_products_list')->group('products', 'products.activeMany');

it('deve retornar o status code 200 quando tentar ativar os produtos estando logado', function ($products)
{
    actingAsUserApi()
        ->postJson(route('products.activeMany'), ['ids' => $products->pluck('id')])
        ->assertStatus(200);
})->with('inactive_products_list')->group('products', 'products.activeMany');

it('deve confirmar que todos os ids de produtos foram ativados', function ($products)
{
    actingAsUserApi()
        ->postJson(route('products.activeMany'), ['ids' => $products->pluck('id')])
        ->assertStatus(200);

    expect(
        actingAsUserApi()
            ->getJson(route('products.index'))
            ->json()['data']
    )->toHaveLength(5)
    ->each(fn ($product) => $product->toMatchArray(['active' => Product::ACTIVE_YES]));

})->with('inactive_products_list')->group('products', 'products.activeMany');

it('deve retornar o status code 422 se não informar os ids dos produtos que serão ativados', function ()
{
    actingAsUserApi()
        ->postJson(route('products.activeMany'))
        ->assertStatus(422);
})->group('products', 'products.activeMany.validation');
