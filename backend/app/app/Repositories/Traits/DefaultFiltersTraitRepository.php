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

    protected function setQueryAndFilters(Builder $query, array $filters = []): self
    {
        $this->query = $query;
        $this->filters = $filters;

        return $this;
    }

    protected function applySortBy(): self
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

    protected function applyFilterActive(): self
    {
        if (!empty($this->filters['active'])) {
            $this->query->where('active', $this->filters['active'] == BaseRepository::FILTER_ACTIVE_YES);
        }
        return $this;
    }

    protected function applyFilterColumnLike(string $column): self
    {
        if (!empty($this->filters[$column])) {
            $this->query->where($column, 'like', '%'.$this->filters[$column].'%');
        }
        return $this;
    }

    protected function applyExceptIdFilter(): self
    {
        if (!empty($this->filters['except_id'])) {
            $this->query->whereNotIn('id', (array)$this->filters['except_id']);
        }
        return $this;
    }
}
