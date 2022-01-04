<?php
namespace App\Repositories;

use App\Http\Resources\CategoriaCollection;
use App\Models\Categoria;
use App\Repositories\Traits\DefaultFiltersTraitRepository;
use App\Scopes\ActiveScope;
use Illuminate\Support\Facades\Auth;

/**
 * @property Categoria $model
 */
class CategoriaRepository extends BaseRepository
{
    use DefaultFiltersTraitRepository;

    /**
     * @param Categoria $model
     */
    public function __construct(Categoria $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $itemsPerPage
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function paginate($filters = [], $itemsPerPage = self::PAGINATE_DEFAULT)
    {
        /**
         * @var \Illuminate\Database\Eloquent\Builder
         */
        $query = $this->model::withoutGlobalScope(ActiveScope::class);

        $this->setQueryAndFilters($query, $filters)
            ->applySortBy()
            ->applyFilterActive()
            ->applyFilterColumnLike('nome');

        return new CategoriaCollection(
            $query->paginate($itemsPerPage)
        );
    }

    /**
     * @param array $data
     * @return Categoria
     */
    public function create($data)
    {
        $data['active'] = !isset($data['active']) || $data['active'] ? true : false;
        $data['created_by'] = Auth::user()->id;

        return $this->model->create($data);
    }
}
