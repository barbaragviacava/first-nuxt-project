<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    const PAGINATION_DEFAULT = 20;

    const FILTER_ACTIVE_YES = 'yes';
    const FILTER_ACTIVE_NO = 'no';

    /**
     * @var Model
     */
    protected $model;

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param int $itemsPerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $itemsPerPage = self::PAGINATION_DEFAULT)
    {
        return $this->model->paginate($itemsPerPage);
    }

}
