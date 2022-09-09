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
     * @throws DeleteException
     */
    public function findAndDelete($id): int
    {
        try {
            return $this->model::destroy($id);
        } catch (\Exception $error) {
            throw new DeleteException($error->getMessage(), $error->getCode(), $error);
        }
    }

    /**
     * @param Model $model
     * @return boolean
     * @throws DeleteException
     */
    public function delete(Model $model): ?bool
    {
        try {
            return $model->delete();
        } catch (\Exception $error) {
            throw new DeleteException($error->getMessage(), $error->getCode(), $error);
        }
    }

    /**
     * @param array $ids
     * @throws DeleteException
     */
    public function deleteMany(array $ids): void
    {
        try {
            $this->model
                ->whereIn('id', $ids)
                ->delete();
        } catch (\Exception $error) {
            throw new DeleteException($error->getMessage(), $error->getCode(), $error);
        }
    }

}
