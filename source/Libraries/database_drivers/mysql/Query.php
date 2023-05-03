<?php

namespace Libraries\database_drivers\mysql;

use Libraries\database_drivers\BaseBuilder;
use Libraries\database_drivers\Model;
use Libraries\Response\Response;

class Query
{
    use BaseBuilder;

    public Model $model;
    public string $str_where;
    public string $str_order_by;
    public string $str_limit;

    public function __construct($model, $db = null)
    {
        $this->model = $model;
        $this->db = $db;
    }

    public function orderBy($column, $value = 'ASC'): static
    {
        if (isset($this->str_order_by)) {
            $add_query = ' , '.$column.' '.$value;
            $this->str_order_by .= $add_query;
        } else {
            $query = ' ORDER BY '.$column.' '.$value;
            $this->str_order_by = $query;
        }

        return $this;
    }

    public function orderByDesc($column): static
    {
        $this->orderBy($column, 'DESC');

        return $this;
    }

    public function limit($amount): static
    {
        $this->str_limit = ' LIMIT '.$amount;

        return $this;
    }

    public function where($column, $value): static
    {
        $value = cleanData($value);
        if (isset($this->str_where)) {
            $add_query = ' AND '.$column.' = "'.$value.'"';
            $this->str_where .= $add_query;
        } else {
            $query = ' WHERE '.$column.' = "'.$value.'"';
            $this->str_where = $query;
        }

        return $this;
    }

    public function whereIn($column, $values): static
    {
        $values = cleanData($values);
        $values = '("'.implode('", "', $values).'")';
        if (isset($this->str_where)) {
            $add_query = ' AND '.$column.' IN '.$values;
            $this->str_where .= $add_query;
        } else {
            $query = ' WHERE '.$column.' IN '.$values;
            $this->str_where = $query;
        }

        return $this;
    }

    public function first(): Model|null
    {
        $data = $this->callFirst();
        if (empty($data)) {
            return null;
        }
        $this->setAttributes($this->model, $data);

        return $this->model;
    }

    public function find($id): Model|null
    {
        $data = $this->callFind($id);
        if (empty($data)) {
            return null;
        }
        $this->setAttributes($this->model, $data);

        return $this->model;
    }

    public function findOrFail($id): Model
    {
        $data = $this->find($id);
        if ($data === null) {
            abort(404);
        }

        return $data;
    }

    public function get($column = []): array
    {
        $result = [];
        $rows = $this->callGet($column);
        foreach ($rows as $row) {
            $model = clone $this->model;
            $model->setAttributes($model, $row);
            $result[] = $model;
        }

        return $result;
    }

    public function count(): int
    {
        return $this->callCount();
    }

    public function paginate($per_page = 10): array
    {
        $page = (int) request()->get('page');
        if ($page === 0) {
            $page = 1;
        } elseif ($page <= 0) {
            $page = 1;
        }
        $rows = $this->callPaginate("SELECT * FROM {$this->model->table}", $per_page, ($page - 1) * $per_page);
        $result = [];
        foreach ($rows as $row) {
            $model = clone $this->model;
            $model->setAttributes($model, $row);
            $result[] = $model;
        }
        $total = $this->count();
        $last_page = (int) ceil($total / $per_page);

        return [
            'meta' => [
                'current_page' => $page,
                'per_page' => count($result),
                'last_page' => $last_page,
                'first_page_url' => request()->url,
                'last_page_url' => request()->url.'?page='.$last_page,
                'next_page_url' => request()->url.'?page='.($page + 1),
                'prev_page_url' => request()->url.'?page='.($page - 1),
                'total' => $total,
            ],
            'data' => $result,
        ];
    }

}