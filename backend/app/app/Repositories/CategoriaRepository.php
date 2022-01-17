<?php
namespace App\Repositories;

use App\Exceptions\DeleteException;
use App\Http\Resources\CategoriaCollection;
use App\Models\Categoria;
use App\Models\Produto;
use App\Repositories\Traits\DefaultFiltersTraitRepository;
use App\Repositories\Traits\UpdateTraitRepository;
use App\Scopes\ActiveScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @property Categoria $model
 */
class CategoriaRepository extends BaseRepository
{
    use DefaultFiltersTraitRepository;
    use UpdateTraitRepository;

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
            $query->paginate(!empty($filters['limit']) ? $filters['limit'] : $itemsPerPage)
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

    /**
     * @param Categoria $model
     * @return boolean
     */
    public function delete(Categoria $model) {
        if ($this->doIhaveChildren($model->id)) {
            throw new DeleteException('A categoria não pode ser excluida, pois existem outras categorias vinculadas à ela.');
        }
        if ($this->doIhaveProdutos($model->id)) {
            throw new DeleteException('A categoria não pode ser excluida, pois existem produtos vinculadas à ela.');
        }

        try {
            return $model->delete();
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            throw new DeleteException('Não foi possível remover a categoria. Contate o nosso suporte.', $error->getCode(), $error);
        }
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function doIhaveChildren($id) {
        return Categoria::where('categoria_pai_id', $id)->count() > 0;
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function doIhaveProdutos($id) {
        return Produto::where('categoria_id', $id)->count() > 0;
    }

    /**
     * @param Categoria $categoria
     */
    public function toggleActive(Categoria $categoria)
    {
        DB::transaction(function () use ($categoria) {
            $this->setStatus($categoria, !$categoria->active);
        }, 2);
    }

    /**
     * @param Categoria $categoria
     * @param boolean $active
     */
    private function setStatus(Categoria $categoria, $active) {
        $categoriasFilhas = $categoria->categoriasFilhas;

        // Log::debug($categoriasFilhas);

        foreach($categoriasFilhas->all() as $item) {
            // Log::debug('Mudando: '.$item->nome);
            $this->setStatus($item, $active);
            // Log::debug('Saindo de:'.$item->nome);
        }

        $this->update($categoria, [
            'active' => $active,
        ]);
    }

}
