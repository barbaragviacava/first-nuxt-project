<?php
namespace App\Repositories;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Repositories\Traits\DefaultFiltersTraitRepository;
use App\Repositories\Traits\DeleteTraitRepository;
use App\Repositories\Traits\UpdateTraitRepository;
use Illuminate\Support\Facades\Auth;

/**
 * @property Product $model
 */
class ProductRepository extends BaseRepository
{
    use DefaultFiltersTraitRepository;
    use UpdateTraitRepository;
    use DeleteTraitRepository;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $itemsPerPage
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function paginate($filters = [], $itemsPerPage = self::PAGINATION_DEFAULT)
    {
        /**
         * @var \Illuminate\Database\Eloquent\Builder
         */
        $query = $this->model::withoutGlobalScope(ActiveScope::class)
            ->with('category');

        $this->setQueryAndFilters($query, $filters)
            ->applySortBy()
            ->applyFilterActive()
            ->applyFilterColumnLike('name');

        if (!empty($filters['category_id'])) {
            $query->whereIn('category_id', (array)$filters['category_id']);
        }

        return new ProductCollection(
            $query->paginate(!empty($filters['limit']) ? $filters['limit'] : $itemsPerPage)
        );
    }

    public function create(array $data): Product
    {
        $data['active'] = !isset($data['active']) || $data['active'];
        $data['created_by'] = Auth::user()->id;

        return $this->model->create($data);
    }

    public function toggleActive(Product $product): void
    {
        $this->update($product, [
            'active' => !$product->active,
        ]);
    }

    public function setActiveValue(array $ids, bool $active): void
    {
        Product::whereIn('id', $ids)
            ->update(['active' => $active]);
    }

}
