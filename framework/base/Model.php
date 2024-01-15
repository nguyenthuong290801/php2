<?php

namespace Illuminate\framework\base;

use Illuminate\framework\Application;
use Illuminate\framework\interface\Model as ModelInterface;
use Cocur\Slugify\Slugify;

class Model implements ModelInterface
{
    protected $table;
    protected $columns;
    public \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Application::$app->db->pdo;
    }

    public function table($table)
    {
        return $this->table = $table;
    }

    public function columns($columns)
    {
        return $this->columns = $columns;
    }

    public function toString()
    {
        $columnsString = implode(', ', $this->columns) ?? '*';
        
        return $columnsString;
    }

    public function all($order_by = 'ASC', $limit = null, $offset = 0)
    {
        if ($limit !== null) {
            return $this->limit($limit, $offset);
        }

        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE deleted_at IS NULL 
              ORDER BY created_at $order_by";
        $stmt = $this->pdo->prepare($query);
        
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function paginate($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;

        return $this->all($perPage, $offset);
    }

    public function paginateWithTrashed($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;

        return $this->withTrashed($perPage, $offset);
    }

    public function limit($limit, $offset = 0)
    {
        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE deleted_at IS NULL 
              ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $params = ['limit' => $limit, 'offset' => $offset];
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $params['limit'], \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $params['offset'], \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function limitWithTrashed($limit, $offset = 0)
    {
        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE deleted_at IS NOT NULL 
              ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $params = ['limit' => $limit, 'offset' => $offset];
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $params['limit'], \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $params['offset'], \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function withTrashed($limit = null, $offset = 0)
    {
        if ($limit !== null) {
            return $this->limitWithTrashed($limit, $offset);
        }

        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE deleted_at IS NOT NULL ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function find($id)
    {
        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE id = :id";
        $params = [':id' => $id];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function where($conditions = [], $operator = null)
    {
        $whereClause = '';
        $params = [];

        foreach ($conditions as $column => $value) {
            $paramName = ':' . $column;
            $whereClause .= "$column $operator $paramName AND ";
            $params[$paramName] = $value;
        }

        $whereClause = rtrim($whereClause, ' AND ');

        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE $whereClause";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findSlug($slug)
    {
        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE slug = :slug";
        $params = [':slug' => $slug];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findCmt($id)
    {
        $query = "SELECT review, comment_name FROM comment 
                  INNER JOIN product ON comment.product_id = product.id 
                  WHERE comment.product_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {

        if (isset($data['name'])) {
            $searchValue = 'name';
            $matchingKeys = preg_grep("/$searchValue/i", array_keys($data));
            $matchingKeysString = implode(', ', $matchingKeys);
            $slug = $this->slug($data["$matchingKeysString"]);
            $data['slug'] = $slug;
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function createFor(array $dataArray)
    {
        foreach ($dataArray as $data) {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
        }

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($query);

        foreach ($dataArray as $data) {
            $stmt->execute($data);
        }

        return $this->pdo->lastInsertId();
    }

    public function updateFor($id, array $dataArray)
    {
        $columns = '';
        foreach ($dataArray as $key => $value) {
            $columns .= "$key = :$key, ";
        }
        $columns = rtrim($columns, ', ');

        $query = "UPDATE {$this->table} SET $columns WHERE id = :id";
        $data['id'] = $id;

        $stmt = $this->pdo->prepare($query);
        for ($i = 0; $i < count($dataArray); $i++) {
            $stmt->execute($data);
        }

        return $stmt->rowCount();
    }

    function slug($text)
    {
        $slugify = new Slugify();

        return $slugify->slugify($text);
    }


    public function update($id, array $data)
    {
        $columns = '';
        foreach ($data as $key => $value) {
            $columns .= "$key = :$key, ";
        }
        $columns = rtrim($columns, ', ');

        $query = "UPDATE {$this->table} SET $columns WHERE id = :id";
        $data['id'] = $id;

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount();
    }

    public function softDelete($id)
    {
        $query = "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        
        return $stmt->rowCount();
    }

    public function restore($id)
    {

        $query = "UPDATE {$this->table} SET deleted_at = NULL WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount();
    }

    public function login($email, $password)
    {
        $query = "SELECT {$this->toString()} FROM {$this->table} WHERE email = :email AND password = :password";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email, 'password' => $password]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
