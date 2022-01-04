<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Resources\CategoriaCollection;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->repository->paginate($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaStoreRequest $request)
    {
        return $this->repository->create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $Categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $Categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $Categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $Categoria)
    {
        //
    }
}
