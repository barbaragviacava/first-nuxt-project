<?php
namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
trait CreateTraitRepository
{
    /**
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        $model = new $this->model;
        $model->fill($data);
        return $model->save();
    }
}
