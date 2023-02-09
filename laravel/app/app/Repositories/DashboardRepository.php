<?php
namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;

class DashboardRepository extends BaseRepository
{
    public function countProducts(): int
    {
        return Product::activated()->count();
    }

    public function countCategories(): int
    {
        return Category::activated()->count();
    }
}
