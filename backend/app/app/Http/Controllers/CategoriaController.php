<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use Illuminate\Http\Request;

/**
 * @property CategoriaRepository $repository
 */
class CategoriaController extends Controller
{
    /**
     * @param CategoriaRepository $repository
     */
    public function __construct(CategoriaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->repository->paginate($request->all());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
        return new CategoriaResource($this->repository->create($request->all())->load('categoriaPai'));
    }

    /**
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        return new CategoriaResource($categoria->load('categoriaPai'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        return new CategoriaResource($this->repository->update($categoria, $request->all())->load('categoriaPai'));
    }

    /**
     * @param  \App\Models\Categoria  $categoria
     */
    public function destroy(Categoria $categoria)
    {
        $this->repository->delete($categoria);
    }

    /**
     * @param Categoria $categoria
     */
    public function toggleActive(Categoria $categoria)
    {
        $this->repository->toggleActive($categoria);
    }
}
