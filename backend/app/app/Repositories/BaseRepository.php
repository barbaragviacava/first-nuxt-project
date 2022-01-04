<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    const PAGINATE_DEFAULT = 20;

    const FILTRO_ACTIVE_SIM = 'sim';
    const FILTRO_ACTIVE_NAO = 'nao';

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param int $id
     * @return Model
     */
    public function find($id) {
        return $this->model->findOrFail($id);
    }

    /**
     * @param int $itemsPerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($itemsPerPage = self::PAGINATE_DEFAULT) {
        return $this->modal->paginate($itemsPerPage);
    }
}
