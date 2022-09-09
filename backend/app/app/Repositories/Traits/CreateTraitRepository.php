<?php
namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
trait CreateTraitRepository
{
    public function create(array $data): bool
    {
        $model = new $this->model;
        $model->fill($data);
        return $model->save();
    }
}
