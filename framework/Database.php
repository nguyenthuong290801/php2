<?php

namespace Illuminate\framework;

use Exception;
use PDOException;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }


    public function execute($query, $param = null)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($param);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Đã xảy ra lỗi khi thực hiện truy vấn: " . $e->getMessage());
        }
    }

    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
