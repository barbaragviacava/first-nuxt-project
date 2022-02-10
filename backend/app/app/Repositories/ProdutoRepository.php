<?php
namespace App\Repositories;

use App\Http\Resources\ProdutoCollection;
use App\Models\Produto;
use App\Repositories\Traits\DefaultFiltersTraitRepository;
use App\Repositories\Traits\DeleteTraitRepository;
use App\Repositories\Traits\UpdateTraitRepository;
use Illuminate\Support\Facades\Auth;

/**
 * @property Produto $model
 */
class ProdutoRepository extends BaseRepository
{
    use DefaultFiltersTraitRepository;
    use UpdateTraitRepository;
    use DeleteTraitRepository;

    /**
     * @param Produto $model
     */
    public function __construct(Produto $model)
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
        $query = $this->model::withoutGlobalScope(ActiveScope::class)
            ->with('categoria');

        $this->setQueryAndFilters($query, $filters)
            ->applySortBy()
            ->applyFilterActive()
            ->applyFilterColumnLike('nome');

        if (!empty($filters['categoria_id'])) {
            $query->whereIn('categoria_id', (array)$filters['categoria_id']);
        }

        return new ProdutoCollection(
            $query->paginate(!empty($filters['limit']) ? $filters['limit'] : $itemsPerPage)
        );
    }

    /**
     * @param array $data
     * @return Produto
     */
    public function create($data)
    {
        $data['active'] = !isset($data['active']) || $data['active'] ? true : false;
        $data['created_by'] = Auth::user()->id;

        return $this->model->create($data);
    }

    /**
     * @param Produto $produto
     */
    public function toggleActive(Produto $produto)
    {
        $this->update($produto, [
            'active' => !$produto->active,
        ]);
    }
}
