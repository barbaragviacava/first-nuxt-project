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

    public function countCategories(): int
    {
        return $this->repository->countCategories();
    }

    public function countProducts(): int
    {
        return $this->repository->countProducts();
    }
}
