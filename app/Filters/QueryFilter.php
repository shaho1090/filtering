<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    protected Builder $builder;
    protected int $perPage;
    protected ?string $sortField;
    protected mixed $sortDirection;
    protected ?string $model;

    /**
     * QueryFilter constructor.
     */
    public function __construct(
        protected readonly Request $request,
    ) {
        $this->perPage = 10;
        $this->sortField = null;
        $this->sortDirection = 'DESC';
        $this->setModel();
    }

    abstract public function setModel();

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            $methodName = Str::camel($name);

            if (method_exists($this, $methodName)) {
                call_user_func_array([$this, $methodName], [$value]);
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return $this->request->toArray();
    }

    protected function findFilter(string $filter): mixed
    {
        foreach ($this->request->query() as $item => $value) {
            if (Str::camel($item) === $filter) {
                return $value;
            }
        }

        return false;
    }

    public function getPerPageCount(): int
    {
        return $this->perPage;
    }

    public function perPageCount($perPage = 10): Builder
    {
        if ($perPage <= 200) {
            $this->perPage = $perPage;
        }

        return $this->builder;
    }

    public function sortBy($field = 'id'): Builder
    {
        if (is_null($this->model)) {
            return $this->builder;
        }

        if (in_array($field, (new $this->model())->getFillable())) {
            $this->sortField = $field;
        }

        return $this->builder;
    }

    public function sortDirection($direction = 'DESC'): Builder
    {
        $direction = strtoupper($direction);

        if (in_array($direction, ['DESC', 'ASC'])) {
            $this->sortDirection = $direction;
        }

        return $this->builder;
    }

    public function getSortField(): string
    {
        return $this->sortField ?: (new $this->model())->getKeyName();
    }

    public function getSortDirection()
    {
        return $this->sortDirection;
    }

    public function request(): Request
    {
        return $this->request;
    }
}
