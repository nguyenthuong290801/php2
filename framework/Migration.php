<?php

namespace Illuminate\framework;

use Illuminate\framework\Application;

class Migration
{
    public \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Application::$app->db->pdo;
    }

    public function applyMigration()
    {
        $this->createMigration();
        $appliedMigrations = $this->getAppLiedMigration();
        $newMigrations = [];
        $files = scandir('./database/migrations');
        $toAppLyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toAppLyMigrations as $migration) {

            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once './database/migrations/' . $migration;
            $tableName = substr($migration, strpos($migration, '_') + 21, -10);
            $className = pathinfo($tableName, PATHINFO_FILENAME);

            $fullClassName = 'App\database\migrations\\' . $className;
            $instance = new $fullClassName();
            echo "Applying migration" . PHP_EOL;
            $instance->up();
            echo "Applied migration" . PHP_EOL;
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            echo "All migration are applied";
        }
    }

    public function createMigration()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations 
                        (id INT AUTO_INCREMENT PRIMARY KEY, 
                        migration VARCHAR(255), 
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
                        ENGINE=INNODB;");
    }

    public function getAppliedMigration()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migration)
    {
        $str = implode(',', array_map(fn ($m) => "('$m')", $migration));
        $statement = $this->pdo->prepare("INSERT INTO  migrations (migration) VALUES $str");
        $statement->execute();
    }
}
