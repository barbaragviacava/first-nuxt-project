<?php
namespace App\Repositories;

use App\Models\Categoria;
use App\Models\Produto;

class DashboardRepository extends BaseRepository
{
    /**
     * @return int
     */
    public function contarProdutos()
    {
        return Produto::ativado()->count();
    }

    /**
     * @return int
     */
    public function contarCategorias()
    {
        return Categoria::ativado()->count();
    }
}
