<?php

namespace Illuminate\framework;

class Blueprint
{
    protected $columns = [];

    public function id()
    {
        $this->columns[] = "`id` INT AUTO_INCREMENT PRIMARY KEY";

        return $this;
    }

    public function integer($column)
    {
        $this->columns[] = "`$column` INT";

        return $this;
    }

    public function string($column, $length = 255)
    {
        $this->columns[] = "`$column` VARCHAR($length)";

        return $this;
    }

    public function unique()
    {
        $lastColumn = end($this->columns);
        $this->columns[count($this->columns) - 1] = $lastColumn . ' UNIQUE';

        return $this;
    }

    public function unsigned()
    {
        $lastColumn = end($this->columns);
        $this->columns[count($this->columns) - 1] = $lastColumn . ' UNSIGNED';

        return $this;
    }

    public function enum($column, array $values)
{
    $values = implode("', '", $values);
    $this->columns[] = "`$column` ENUM('$values')";

    return $this;
}


    public function foreignId($column, $table, $referenceColumn = 'id')
    {
        $this->columns[] = "FOREIGN KEY (`$column`) REFERENCES `$table`(`$referenceColumn`)";

        return $this;
    }
    

    public function references($table, $column = 'id')
    {
        $this->columns[] = "REFERENCES `$table`(`$column`)";

        return $this;
    }

    public function on($table)
    {
        $lastColumn = end($this->columns);
        $this->columns[count($this->columns) - 1] = $lastColumn . " ON `$table`";

        return $this;
    }

    public function primary($column)
    {
        $this->columns[] = "PRIMARY KEY (`$column`)";

        return $this;
    }

    public function increments($column)
    {
        $this->columns[] = "`$column` INT AUTO_INCREMENT";

        return $this;
    }

    public function bigIncrements($column)
    {
        $this->columns[] = "`$column` BIGINT AUTO_INCREMENT";

        return $this;
    }

    public function bigInteger($column)
    {
        $this->columns[] = "`$column` BIGINT";

        return $this;
    }

    public function float($column)
    {
        $this->columns[] = "`$column` FLOAT";

        return $this;
    }

    public function decimal($column, $total_digits, $decimal_digits)
    {
        $this->columns[] = "`$column` DECIMAL($total_digits, $decimal_digits)";

        return $this;
    }

    public function text($column)
    {
        $this->columns[] = "`$column` TEXT";

        return $this;
    }

    public function boolean($column)
    {
        $this->columns[] = "`$column` BOOLEAN";

        return $this;
    }

    public function date($column)
    {
        $this->columns[] = "`$column` DATE";

        return $this;
    }

    public function dateTime($column)
    {
        $this->columns[] = "`$column` DATETIME";

        return $this;
    }

    public function time($column)
    {
        $this->columns[] = "`$column` TIME";

        return $this;
    }

    public function year($column)
    {
        $this->columns[] = "`$column` YEAR";

        return $this;
    }

    public function timestamp($column)
    {
        $this->columns[] = "`$column` TIMESTAMP";

        return $this;
    }

    public function timestamps()
    {
        $this->columns[] = "`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns[] = "`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

        return $this;
    }

    public function softDeletes()
    {
        $this->columns[] = "`deleted_at` TIMESTAMP NULL";

        return $this;
    }

    public function json($column)
    {
        $this->columns[] = "`$column` JSON";

        return $this;
    }


    public function getColumns()
    {
        return implode(",\n", $this->columns);
    }
}