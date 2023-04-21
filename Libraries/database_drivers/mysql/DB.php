<?php

namespace Libraries\database_drivers\mysql;

use Libraries\database_drivers\Model;
use JetBrains\PhpStorm\Pure;
use mysqli;

class DB extends Query
{
    public mixed $db_connection;
    public static mixed $connection;
    public string $table;

    #[Pure]
    public function __construct()
    {
        parent::__construct($this->table ?? '');
    }

    public static function table($table): Model
    {
        $model = new ('\App\Models\\'.ucfirst($table))();

        $model->table = $table;
        $model->db_connection = self::$connection;

        return $model;
    }

    public function beginTransaction(): void
    {
        $connect = new mysqli
        (
            env('DATABASE_HOST'), env('DATABASE_USERNAME'),
            env('DATABASE_PASSWORD'), env('DATABASE_NAME')
        );
        $connect->set_charset('utf8');
        $connect->begin_transaction();

        $this->db_connection = $connect;
        self::$connection = $connect;
    }

    public function rollBack(): void
    {
        $connect = $this->db_connection;
        $connect->rollback();
        $connect->close();

        $this->db_connection = null;
        self::$connection = null;
    }

    public function commit(): void
    {
        $connect = $this->db_connection;
        $connect->commit();
        $connect->close();

        $this->db_connection = null;
        self::$connection = null;
    }

}