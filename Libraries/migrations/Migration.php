<?php

namespace Libraries\migrations;

use Libraries\database_drivers\mysql\DB;

abstract class Migration extends Table
{

    public string $table = '';

    abstract public function up(): void;

    public function migrate(): void
    {
        $str_columns = implode(',', $this->columns);
        $connection = $this->getConnection();
        mysqli_query($connection, "CREATE TABLE $this->table ( $str_columns )");
        mysqli_close($connection);
    }

    public function fresh(): void
    {
        $connection = $this->getConnection();
        mysqli_query($connection, "DROP DATABASE IF EXISTS ". env('DATABASE_NAME'));
        mysqli_query($connection, "CREATE DATABASE ". env('DATABASE_NAME'));
        mysqli_close($connection);
    }

    private function getConnection(): bool|\mysqli|null
    {
        return mysqli_connect(env('DATABASE_HOST'), env('DATABASE_USERNAME'), env('DATABASE_PASSWORD'), env('DATABASE_NAME'));
    }


}
