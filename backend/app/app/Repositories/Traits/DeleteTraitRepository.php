<?php
namespace App\Repositories\Traits;

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
    public function delete($id) {
        $registroEncontrado = $this->model->findOrFail($id);
        return $registroEncontrado->delete();
    }
}
