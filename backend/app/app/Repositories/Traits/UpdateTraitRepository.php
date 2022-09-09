<?php
namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
trait UpdateTraitRepository
{
    public function findAndUpdate(int $id, array $data): Model
    {
        return $this->update($this->model->findOrFail($id), $data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->fill($data);
        $model->save();
        return $model;
    }
}
