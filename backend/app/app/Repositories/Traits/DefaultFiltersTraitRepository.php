<?php
namespace App\Repositories\Traits;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

trait DefaultFiltersTraitRepository
{
    /**
     * @var array
     */
    private $filters = [];

    /**
     * @var Builder
     */
    private $query = null;

    /**
     * @param Builder $query
     * @return DefaultFiltersTraitRepository
     */
    protected function setQueryAndFilters(Builder $query, $filters = []) {
        $this->query = $query;
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param array $filters
     * @return DefaultFiltersTraitRepository
     */
    protected function applySortBy()
    {
        if (!empty($this->filters['sortBy'])) {

            $sortDirection = 'asc';
            if (!empty($this->filters['sortDirection'])) {
                $sortDirection = $this->filters['sortDirection'];
            }
            $this->query->orderBy($this->filters['sortBy'], $sortDirection);
        }
        return $this;
    }

    /**
     * @param array $filters
     * @return DefaultFiltersTraitRepository
     */
    protected function applyFilterActive()
    {
        if (!empty($this->filters['active'])) {
            $this->query->where('active', $this->filters['active'] == BaseRepository::FILTRO_ACTIVE_SIM);
        }
        return $this;
    }

    /**
     * @param string $column
     * @param array $filters
     * @return DefaultFiltersTraitRepository
     */
    protected function applyFilterColumnLike($column)
    {
        if (!empty($this->filters[$column])) {
            $this->query->where($column, 'like', '%'.$this->filters[$column].'%');
        }
        return $this;
    }
}
