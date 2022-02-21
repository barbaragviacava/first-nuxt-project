<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\Request;

/**
 * @property ProdutoRepository $repository
 */
class ProdutoController extends Controller
{
    /**
     * @param ProdutoRepository $repository
     */
    public function __construct(ProdutoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
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
    public function store(ProdutoRequest $request)
    {
        return new ProdutoResource($this->repository->create($request->all())->load('categoria'));
    }

    /**
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        return new ProdutoResource($produto->load('categoria'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        return new ProdutoResource($this->repository->update($produto, $request->all())->load('categoria'));
    }

    /**
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        $this->repository->delete($produto);
    }

    /**
     * @param Produto $produto
     */
    public function toggleActive(Produto $produto)
    {
        $this->repository->toggleActive($produto);
    }
}
