<?php

namespace Libraries\database_drivers\mysql;

use mysqli;

trait Builder
{
    protected $db;
    public int $id;

    public function database(): mysqli
    {
        if (empty($this->db) && empty($this->db_connection)) {
            $this->db = new mysqli
            (
                env('DATABASE_HOST'), env('DATABASE_USERNAME'),
                env('DATABASE_PASSWORD'), env('DATABASE_NAME')
            );
            $this->db->set_charset('utf8');
            return $this->db;
        }

        return $this->db ?? $this->db_connection;
    }

    public function __destruct()
    {
        if ((! isset($this->db_connection)) && $this->database()->connect_errno) {
            $this->database()->close();
        }
    }

    public function callFirst(): bool|array|null
    {
        $query = 'SELECT * FROM '.$this->getTable();
        $query .= $this->str_where ?? '';
        $query .= ' LIMIT 1';

        return $this->database()->query($query)->fetch_assoc();
    }

    public function callFind($id): bool|array|null
    {
        $id = cleanData($id);
        $query = 'SELECT * FROM '.$this->getTable();
        $query .= $this->str_where ?? '';
        $query .= isset($this->str_where) ? ' AND id = "'.$id.'"' : ' WHERE id= "'.$id.'"';
        $query .= ' LIMIT 1';

        return $this->database()->query($query)->fetch_assoc();
    }

    public function callGet($column)
    {
        if (empty($column)) {
            $column = '* ';
        } else {
            $column = 'id, '.implode(', ', $column).' ';
        }
        $query = 'SELECT '.$column.'FROM '.$this->getTable();
        $query .= $this->str_where ?? '';
        $query .= $this->str_order_by ?? '';
        $query .= $this->str_limit ?? '';

        return $this->database()->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function callCount(): int
    {
        $query = 'SELECT COUNT(*) FROM '.$this->getTable();
        $query .= $this->str_where ?? '';
        $query .= $this->str_order_by ?? '';

        return (int) $this->database()->query($query)->fetch_row()[0];
    }

    public function callPaginate($query, $limit, $offset)
    {
        $query .= $this->str_where ?? '';
        $query .= $this->str_order_by ?? '';
        $query .= ' LIMIT '.$limit.' OFFSET '.$offset;

        return $this->database()->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function callOrderBy($column, $values, $model): Query
    {
        $query = new Query($model);
        $query->orderBy($column, $values);

        return $query;
    }

    public function callOrderByDesc($column, $model): Query
    {
        $query = new Query($model);
        $query->orderBy($column, 'DESC');

        return $query;
    }

    public function callLimit($amount, $model): Query
    {
        $query = new Query($model);
        $query->limit($amount);

        return $query;
    }

    public function callWhere($column, $values, $model): Query
    {
        $query = new Query($model);
        $query->where($column, $values);

        return $query;
    }

    public function callWhereIn($column, $value, $model): Query
    {
        $query = new Query($model);
        $query->whereIn($column, $value);

        return $query;
    }

    public function callCreate($data = [], $table = null): int
    {
        $data = cleanData($data);
        $columns = '('.implode(', ', array_keys($data)).')';
        $values = $this->getCreateValues($data);
        $query = 'INSERT INTO '.$table.' '.$columns.' VALUES '.$values;
        $this->database()->query($query);

        return $this->database()->insert_id;
    }

    public function callInsert($records = [], $table = null): bool
    {
        if (empty($records)) {
            return false;
        }
        $record_values = [];
        foreach ($records as $record) {
            $record_values[] = $this->getCreateValues($record);
        }
        $columns = '('.implode(', ', array_keys($records[0])).')';
        $query = 'INSERT INTO '.$table.' '.$columns.' VALUES '.implode(', ', $record_values);
        $this->database()->query($query);

        return true;
    }

    public function callUpdate($data = []): bool
    {
        $data = cleanData($data);
        $str_set = $this->getUpdateValues($data);
        $query = 'UPDATE '.$this->getTable().' SET '.$str_set;
        $query .= $this->str_where ?? '';

        $id = $this->id ?? null;
        if (isset($id)) {
            if (isset($this->str_where)) {
                $query .= ' AND id = "'.$id.'"';
            } else {
                $query .= ' WHERE id= "'.$id.'"';
            }
        }

        return $this->database()->query($query);
    }

    public function callDelete(): bool
    {
        $query = 'DELETE FROM '.$this->getTable();
        $query .= isset($this->id) ? ' WHERE id = "'.$this->id.'"' : '';
        $query .= $this->str_where ?? '';
        $this->database()->query($query);

        return ($this->database()->affected_rows > 0 && $this->database()->affected_rows);
    }

    public function callDestroy($ids): int
    {
        $count = 0;
        foreach ($ids as $id) {
            $this->id = $id;
            if ($this->callDelete()) {
                $count++;
            }
        }

        return $count;
    }

    public function callRaw($sql)
    {
        return $this->database()->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function setAttributes($model, $data): void
    {
        foreach ($data as $key => $value) {
            $model->$key = $value;
            $model->attributes[$key] = $value;
        }
    }

    private function getUpdateValues($data): string
    {
        $str_set = '';
        foreach ($data as $column => $value) {
            if ($value === null) {
                $str_set .= $column.' = NULL, ';
            } elseif (in_array($column, $this->not_string_attributes ?? [], true)) {
                $str_set .= $column.' = '.$value.', ';
            } else {
                $str_set .= $column.' = "'.$value.'", ';
            }
        }

        return substr($str_set, 0, -2);
    }

    private function getCreateValues($data): string
    {
        $values = '(';
        foreach ($data as $column => $value) {
            if ($value === null) {
                $values .= 'NULL,';
            } elseif (in_array($column, $this->not_string_attributes ?? [], true)) {
                $values .= $value.',';
            } else {
                $values .= '"'.$value.'",';
            }
        }

        return substr($values, 0, -1).')';
    }

    private function getTable(): string
    {
        return $this->table ?? $this->model->table;
    }
}