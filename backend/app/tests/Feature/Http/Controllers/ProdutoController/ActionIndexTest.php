<?php

use App\Models\Produto;
use App\Repositories\ProdutoRepository;

use function Pest\Laravel\getJson;

it('deve retornar código 401 ao tentar consultar os produtos sem estar logado', function () {

    getJson(route('produtos.index'))
        ->assertStatus(401);

})->group('produtos', 'produtos.index');

it('deve retornar código 200 ao tentar consultar os produtos quando logado', function () {

    actingAsUserApi()
        ->getJson(route('produtos.index'))
        ->assertStatus(200);

})->group('produtos', 'produtos.index');

it('deve retornar um array com a estrutura [\'data\', \'meta\', \'links\'] ao consultar os produtos', function () {

    actingAsUserApi()
        ->getJson(route('produtos.index'))
        ->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

})->group('produtos', 'produtos.index');

it('deve retornar uma lista de 15 produtos', function () {

    $produtosAtivos = Produto::factory()->count(10)->ativado()->create();
    $produtosInativos = Produto::factory()->count(5)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('produtos.index'));

    expect($resposta['data'])
        ->toHaveLength(count($produtosAtivos) + count($produtosInativos));

})->group('produtos', 'produtos.index');

it('deve retornar uma lista de 10 produtos quando filtrado por apenas ativos', function () {

    $produtosAtivos = Produto::factory()->count(10)->ativado()->create();
    Produto::factory()->count(5)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('produtos.index', ['active' => ProdutoRepository::FILTRO_ACTIVE_SIM]));

    expect($resposta['data'])
        ->toHaveLength(count($produtosAtivos));

})->group('produtos', 'produtos.index', 'produtos.index.filtros');

it('deve retornar uma lista de 5 produtos quando filtrado por apenas inativos', function () {

    Produto::factory()->count(10)->ativado()->create();
    $produtosInativos = Produto::factory()->count(5)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('produtos.index', ['active' => ProdutoRepository::FILTRO_ACTIVE_NAO]));

    expect($resposta['data'])
        ->toHaveLength(count($produtosInativos));

})->group('produtos', 'produtos.index', 'produtos.index.filtros');

it('deve retornar um usuário chamado "Geralt de Rivia" quando filtrado pelo nome "de r"', function () {

    $nomeProduto = [
        'nome' => 'Geralt de Rivia',
    ];

    Produto::factory()->count(1)->create($nomeProduto);

    $resposta = actingAsUserApi()
        ->getJson(route('produtos.index', ['nome' => 'de r']));

    expect($resposta['data'])
        ->toHaveLength(1)
        ->each(fn ($produto) => $produto->toMatchArray($nomeProduto));

})->group('produtos', 'produtos.index', 'produtos.index.filtros');

it('não deve retornar nenhum produto se filtrado por apenas ativos e não tiver nenhum ativo', function () {

    Produto::factory()->count(2)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('produtos.index', ['active' => ProdutoRepository::FILTRO_ACTIVE_SIM]));

    expect($resposta['data'])
        ->toHaveLength(0);

})->group('produtos', 'produtos.index', 'produtos.index.filtros');

it('deve retornar uma lista de 20 produtos (paginação)', function () {

    Produto::factory()->count(30)->ativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('produtos.index'));

    expect($resposta['data'])
        ->toHaveLength(ProdutoRepository::PAGINATE_DEFAULT);

})->group('produtos', 'produtos.index', 'produtos.index.paginacao');
