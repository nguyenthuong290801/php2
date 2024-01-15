<?php

namespace Illuminate\framework;

use Illuminate\framework\Application;

class Schema
{
    public \PDO $pdo;
    public $columns;

    public function __construct()
    {
        $this->pdo = Application::$app->db->pdo;
        $this->columns = new Blueprint();
    }
    
    public function create($table, $callback)
    {
        $columns = $this->columns;
        $callback($columns);

        $sql = "CREATE TABLE `$table` (\n";
        $sql .= $columns->getColumns();
        $sql .= "\n)";

        $this->pdo->exec($sql);
    }

    public function update($table, $callback)
    {
        $columns = $this->columns;
        $callback($columns);
    
        $sql = "ALTER TABLE `$table` ";
        $sql .= $columns->getColumns();
    
        $this->pdo->exec($sql);
    }    

    public function dropIfExists($table)
    {
        $sql = "DROP TABLE IF EXISTS `$table`";

        $this->pdo->exec($sql);
    }
}
