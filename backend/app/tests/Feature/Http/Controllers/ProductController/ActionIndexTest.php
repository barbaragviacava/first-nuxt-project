<?php

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;

it('deve retornar código 401 ao tentar consultar os produtos sem estar logado', function () {

    $this->getJson(route('products.index'))
        ->assertStatus(401);

})->group('products', 'products.index');

it('deve retornar código 200 ao tentar consultar os produtos quando logado', function () {

    actingAsUserApi()
        ->getJson(route('products.index'))
        ->assertStatus(200);

})->group('products', 'products.index');

it('deve retornar um array com a estrutura [\'data\', \'meta\', \'links\'] ao consultar os produtos', function () {

    actingAsUserApi()
        ->getJson(route('products.index'))
        ->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

})->group('products', 'products.index');

it('deve retornar uma lista de 15 produtos', function () {

    $activeProducts = Product::factory()->count(10)->activated()->create();
    $inactiveProducts = Product::factory()->count(5)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('products.index'));

    expect($response['data'])
        ->toHaveLength(count($activeProducts) + count($inactiveProducts));

})->group('products', 'products.index');

it('deve retornar uma lista de 10 produtos quando filtrado por apenas ativos', function () {

    $activeProducts = Product::factory()->count(10)->activated()->create();
    Product::factory()->count(5)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('products.index', ['active' => ProductRepository::FILTER_ACTIVE_YES]));

    expect($response['data'])
        ->toHaveLength(count($activeProducts));

})->group('products', 'products.index', 'products.index.filters');

it('deve retornar uma lista de 5 produtos quando filtrado por apenas inativos', function () {

    Product::factory()->count(10)->activated()->create();
    $inactiveProducts = Product::factory()->count(5)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('products.index', ['active' => ProductRepository::FILTER_ACTIVE_NO]));

    expect($response['data'])
        ->toHaveLength(count($inactiveProducts));

})->group('products', 'products.index', 'products.index.filters');

it('deve retornar um produto chamado "Geralt de Rivia" quando filtrado pelo nome "de r"', function () {

    $newProduct = [
        'name' => 'Geralt de Rivia',
    ];

    Product::factory()->count(1)->create($newProduct);

    $response = actingAsUserApi()
        ->getJson(route('products.index', ['name' => 'de r']));

    expect($response['data'])
        ->toHaveLength(1)
        ->each(fn ($product) => $product->toMatchArray($newProduct));

})->group('products', 'products.index', 'products.index.filters');

it('não deve retornar nenhum produto se filtrado por apenas ativos e não tiver nenhum ativo', function () {

    Product::factory()->count(2)->inactivated()->create();

    $response = actingAsUserApi()
        ->getJson(route('products.index', ['active' => ProductRepository::FILTER_ACTIVE_YES]));

    expect($response['data'])
        ->toHaveLength(0);

})->group('products', 'products.index', 'products.index.filters');

it('deve retornar uma lista de 20 produtos (paginação)', function () {

    Product::factory()->count(30)->activated()->create();

    $response = actingAsUserApi()
        ->getJson(route('products.index'));

    expect($response['data'])
        ->toHaveLength(ProductRepository::PAGINATION_DEFAULT);

})->group('products', 'products.index', 'products.index.pagination');

it('deve retornar um produto chamado "Geralt de Rivia" quando filtrado pela categoria "Witcher"', function () {

    Product::factory()->count(5)->activated()->create();

    $witcherCategoryId = Category::factory()->create(['name' => 'Witcher'])->id;
    $newProduct = [
        'name' => 'Geralt de Rivia',
        'category_id' => $witcherCategoryId
    ];
    Product::factory()->create($newProduct);

    $response = actingAsUserApi()
        ->getJson(route('products.index', ['category_id' => $witcherCategoryId]));

    expect($response['data'])
        ->toHaveLength(1)
        ->each(fn ($product) => $product->toMatchArray($newProduct));

})->group('products', 'products.index', 'products.index.filters');
