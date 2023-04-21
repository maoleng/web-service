<?php

namespace Libraries\migrations;

class Table
{

    public array $columns;

    public function id(): void
    {
        $this->columns[] = 'id int AUTO_INCREMENT unique not null primary key';
    }

    public function string($column, $length = 255): static
    {
        $this->columns[] = "$column varchar($length) not null";

        return $this;
    }

    public function integer($column): static
    {
        $this->columns[] = "$column int not null";

        return $this;
    }

    public function float($column): static
    {
        $this->columns[] = "$column float not null";

        return $this;
    }

    public function bit($column): static
    {
        $this->columns[] = "$column bit not null";

        return $this;
    }

    public function dateTime($column): static
    {
        $this->columns[] = "$column datetime not null";

        return $this;
    }

    public function text($column): static
    {
        $this->columns[] = "$column text not null";

        return $this;
    }

    public function foreign($column, $reference_column, $reference_table): static
    {
        $this->columns[] = "$column int not null, foreign key ($column) references $reference_table ($reference_column)";

        return $this;
    }

    public function unique(): static
    {
        $last_column = $this->columns[array_key_last($this->columns)];
        $this->columns[array_key_last($this->columns)] = $last_column.' unique';

        return $this;
    }

    public function nullable(): static
    {
        $last_column = $this->columns[array_key_last($this->columns)];
        $this->columns[array_key_last($this->columns)] = str_replace('not null', '', $last_column);

        return $this;
    }


}
