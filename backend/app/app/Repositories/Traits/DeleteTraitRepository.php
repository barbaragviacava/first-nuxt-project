<?php
namespace App\Repositories\Traits;

use App\Exceptions\DeleteException;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
trait DeleteTraitRepository
{
    /**
     * @param int $id
     * @return boolean
     */
    public function destroy($id) {
        try {
            return $this->model::destroy($id);
        } catch (\Exception $error) {
            throw new DeleteException($error->getMessage(), $error->getCode(), $error);
        }
    }

    /**
     * @param Model $model
     * @return boolean
     */
    public function delete(Model $model) {
        try {
            return $model->delete();
        } catch (\Exception $error) {
            throw new DeleteException($error->getMessage(), $error->getCode(), $error);
        }
    }
}
