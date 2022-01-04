<?php
namespace App\Repositories;

use App\Models\Produto;

/**
 * @property Produto $model
 */
class ProdutoRepository extends BaseRepository
{
    /**
     * @param Produto $model
     */
    public function __construct(Produto $model)
    {
        $this->model = $model;
    }
}
