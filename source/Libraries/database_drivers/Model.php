<?php

namespace Libraries\database_drivers;

use JetBrains\PhpStorm\NoReturn;
use Libraries\database_drivers\mysql\Query;
use Libraries\Response\Response;

#[\AllowDynamicProperties]
abstract class Model
{
    use BaseBuilder;

    public string $table = '';
    protected array $fillable = [];
    protected array $not_string_attributes = [];
    public array $attributes = [];

    public function __construct()
    {
        foreach ($this->fillable as $field) {
            $this->$field = null;
        }
    }

    public function find($id): static|null
    {
        $data = $this->callFind($id);
        if (empty($data)) {
            return null;
        }
        $this->setAttributes($this, $data);

        return $this;
    }

    public function findOrFail($id): static
    {
        $data = $this->find($id);
        if ($data === null) {
            abort(404);
        }

        return $data;
    }

    public function first(): static|null
    {
        $data = $this->callFirst();
        if (empty($data)) {
            return null;
        }
        $this->setAttributes($this, $data);

        return $this;
    }

    public function raw($sql): array
    {
        $result = [];
        $rows = $this->callRaw($sql);
        foreach ($rows as $row) {
            $model = clone $this;
            $model->setAttributes($model, $row);
            $result[] = $model;
        }

        return $result;
    }

    public function rawPaginate($sql, $per_page = 10): array
    {
        return $this->getPagination($sql, $per_page);
    }

    public function get($column = []): array
    {
        $result = [];
        $rows = $this->callGet($column);
        foreach ($rows as $row) {
            $model = clone $this;
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
        return $this->getPagination("SELECT * FROM $this->table", $per_page);
    }

    public function save(): static
    {
        $check = $this->id ?? null;
        $new_data = $this->getData();
        if ($check === null) {
            $this->create($new_data);
        } else {
            $this->update($new_data);
            $this->setAttributes($this, $new_data);
        }

        return $this;
    }

    public function create($data = []): static
    {
        $this->validateFillable(array_keys($data));

        $id = $this->callCreate($data, $this->table);
        $data = ['id' => $id] + $data;
        $this->setAttributes($this, $data);

        return $this;
    }

    public function insert($records = []): bool
    {
        return $this->callInsert($records, $this->table);
    }

    public function orderBy($column, $value = 'ASC'): Query
    {
        $this->validateFillable([$column]);

        return $this->callOrderBy($column, $value, $this);
    }

    public function orderByDesc($column): Query
    {
        $this->validateFillable([$column]);

        return $this->callOrderByDesc($column, $this);
    }

    public function limit($amount): Query
    {
        return $this->callLimit($amount, $this);
    }

    public function where($column, $value): Query
    {
        $this->validateFillable([$column]);

        return $this->callWhere($column, $value, $this);
    }

    public function whereIn($column, $values = []): Query
    {
        $this->validateFillable([$column]);

        return $this->callWhereIn($column, $values, $this);
    }

    private function getPagination($query, $per_page)
    {
        $page = (int) request()->get('page');
        if ($page === 0) {
            $page = 1;
        } elseif ($page <= 0) {
            $page = 1;
        }
        $rows = $this->callPaginate($query, $per_page, ($page - 1) * $per_page);
        $result = [];
        foreach ($rows as $row) {
            $model = clone $this;
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

    private function getData(): array
    {
        $data = [];
        foreach ($this->fillable as $field) {
            $data[$field] = $this->$field;
        }

        return $data;
    }

    #[NoReturn]
    private function validateFillable($fields): void
    {
        $this->fillable[] = 'id';
        $fields = array_diff($fields, $this->fillable);
        if (!empty($fields)) {
            $str_fields = implode(', ', $fields);
            throwHttpException('Invalid fields name: <i>'.$str_fields.'</i> of model '.ucfirst($this->table));
        }
    }
}