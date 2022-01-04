<?php

namespace App\Http\Controllers;

use App\Repositories\DashboardRepository;

/**
 * @property DashboardRepository $repository
 */
class DashboardController extends Controller
{
    /**
     * @param DashboardRepository $repository
     */
    public function __construct(DashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function contarCategorias()
    {
        return $this->repository->contarCategorias();
    }

    public function contarProdutos()
    {
        return $this->repository->contarProdutos();
    }
}
