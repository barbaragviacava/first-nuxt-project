<?php

use App\Models\Product;

it('deve retornar o status code 401 quando tentar inativar os produtos sem estar logado', function ($products)
{
    $this->postJson(route('products.inactiveMany'), ['ids' => $products->pluck('id')])
        ->assertStatus(401);
})->with('active_products_list')->group('products', 'products.inactiveMany');

it('deve retornar o status code 200 quando tentar inativar os produtos estando logado', function ($products)
{
    actingAsUserApi()
        ->postJson(route('products.inactiveMany'), ['ids' => $products->pluck('id')])
        ->assertStatus(200);
})->with('active_products_list')->group('products', 'products.inactiveMany');

it('deve confirmar que todos os ids de produtos foram inativados', function ($products)
{
    actingAsUserApi()
        ->postJson(route('products.inactiveMany'), ['ids' => $products->pluck('id')]);

    expect(
        actingAsUserApi()
            ->getJson(route('products.index'))
            ->json()['data']
    )->toHaveLength(5)
    ->each(fn ($product) => $product->toMatchArray(['active' => Product::ACTIVE_NO]));

})->with('active_products_list')->group('products', 'products.inactiveMany');

it('deve retornar o status code 422 se não informar os ids dos produtos que serão inativados', function ()
{
    actingAsUserApi()
        ->postJson(route('products.inactiveMany'))
        ->assertStatus(422);
})->group('products', 'products.inactiveMany.validation');
