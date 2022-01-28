<?php

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;

use function Pest\Laravel\getJson;

it('deve retornar código 401 ao tentar consultar as categorias sem estar logado', function () {

    getJson(route('categorias.index'))
        ->assertStatus(401);

})->group('categorias', 'categorias.index');

it('deve retornar código 200 ao tentar consultar as categorias quando logado', function () {

    actingAsUserApi()
        ->getJson(route('categorias.index'))
        ->assertStatus(200);

})->group('categorias', 'categorias.index');

it('deve retornar um array com a estrutura [\'data\', \'meta\', \'links\'] ao consultar as categorias', function () {

    actingAsUserApi()
        ->getJson(route('categorias.index'))
        ->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

})->group('categorias', 'categorias.index');

it('deve retornar uma lista de 15 categorias', function () {

    $categoriasAtivas = Categoria::factory()->count(10)->ativado()->create();
    $categoriasInativas = Categoria::factory()->count(5)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('categorias.index'));

    expect($resposta['data'])
        ->toHaveLength(count($categoriasAtivas) + count($categoriasInativas));

})->group('categorias', 'categorias.index');

it('deve retornar uma lista de 10 categorias quando filtrado por apenas ativas', function () {

    $categoriasAtivas = Categoria::factory()->count(10)->ativado()->create();
    Categoria::factory()->count(5)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('categorias.index', ['active' => CategoriaRepository::FILTRO_ACTIVE_SIM]));

    expect($resposta['data'])
        ->toHaveLength(count($categoriasAtivas));

})->group('categorias', 'categorias.index', 'categorias.index.filtros');

it('deve retornar uma lista de 5 categorias quando filtrado por apenas inativas', function () {

    Categoria::factory()->count(10)->ativado()->create();
    $categoriasInativas = Categoria::factory()->count(5)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('categorias.index', ['active' => CategoriaRepository::FILTRO_ACTIVE_NAO]));

    expect($resposta['data'])
        ->toHaveLength(count($categoriasInativas));

})->group('categorias', 'categorias.index', 'categorias.index.filtros');

it('deve retornar um usuário chamado "Geralt de Rivia" quando filtrado pelo nome "de r"', function () {

    $nomeCategoria = [
        'nome' => 'Geralt de Rivia',
    ];

    Categoria::factory()->count(1)->create($nomeCategoria);

    $resposta = actingAsUserApi()
        ->getJson(route('categorias.index', ['nome' => 'de r']));

    expect($resposta['data'])
        ->toHaveLength(1)
        ->each(fn ($categoria) => $categoria->toMatchArray($nomeCategoria));

})->group('categorias', 'categorias.index', 'categorias.index.filtros');

it('não deve retornar nenhuma categoria se filtrado por apenas ativas e não tiver nenhuma ativa', function () {

    Categoria::factory()->count(2)->inativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('categorias.index', ['active' => CategoriaRepository::FILTRO_ACTIVE_SIM]));

    expect($resposta['data'])
        ->toHaveLength(0);

})->group('categorias', 'categorias.index', 'categorias.index.filtros');

it('deve retornar uma lista de 20 categorias (paginação)', function () {

    Categoria::factory()->count(30)->ativado()->create();

    $resposta = actingAsUserApi()
        ->getJson(route('categorias.index'));

    expect($resposta['data'])
        ->toHaveLength(CategoriaRepository::PAGINATE_DEFAULT);

})->group('categorias', 'categorias.index', 'categorias.index.paginacao');
