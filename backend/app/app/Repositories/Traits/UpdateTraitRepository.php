<?php
namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
trait UpdateTraitRepository
{
    /**
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function findAndUpdate($id, $data) {
        return $this->update($this->model->findOrFail($id), $data);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, $data) {
        $model->fill($data);
        $model->save();
        return $model;
    }
}
