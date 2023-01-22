<?php
namespace App\Repositories;

use App\Exceptions\DeleteException;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Traits\DefaultFiltersTraitRepository;
use App\Repositories\Traits\UpdateTraitRepository;
use App\Scopes\ActiveScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @property Category $model
 */
class CategoryRepository extends BaseRepository
{
    use DefaultFiltersTraitRepository;
    use UpdateTraitRepository;

    public function __construct(Category $model)
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
            ->with('parentCategory');

        $this->setQueryAndFilters($query, $filters)
            ->applySortBy()
            ->applyFilterActive()
            ->applyFilterColumnLike('name')
            ->applyExceptIdFilter();

        return new CategoryCollection(
            $query->paginate(!empty($filters['limit']) ? $filters['limit'] : $itemsPerPage)
        );
    }

    public function create(array $data): ?Category
    {
        $data['active'] = !isset($data['active']) || $data['active'];
        $data['created_by'] = Auth::user()->id;

        return $this->model->create($data);
    }

    /**
     * @throws Exception
     */
    public function delete(Category $model): ?bool
    {
        if ($this->doIhaveChildren($model->id)) {
            throw new DeleteException('A categoria não pode ser excluida, pois existem outras categorias vinculadas à ela.');
        }
        if ($this->doIhaveProducts($model->id)) {
            throw new DeleteException('A categoria não pode ser excluida, pois existem produtos vinculadas à ela.');
        }

        try {
            return $model->delete();
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            throw new DeleteException('Não foi possível remover a categoria. Contate o nosso suporte.', $error->getCode(), $error);
        }
    }

    public function doIhaveChildren(int $id): bool
    {
        return Category::where('parent_category_id', $id)->count() > 0;
    }

    public function doIhaveProducts(int $id): bool
    {
        return Product::where('category_id', $id)->count() > 0;
    }

    public function toggleActive(Category $category): void
    {
        DB::transaction(function () use ($category) {
            $this->setStatus($category, !$category->active);
        }, 2);
    }

    private function setStatus(Category $category, bool $active): void
    {
        $childCategories = $category->childCategories;

        foreach($childCategories->all() as $item) {
            $this->setStatus($item, $active);
        }

        $this->update($category, [
            'active' => $active,
        ]);
    }

}
