<?php

namespace Illuminate\framework\factory;

class Model
{
    public static function create($modelClassName, $data)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $lastId = $model->create($data);

        return $lastId;
    }

    public static function createFor($modelClassName, $data)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $lastId = $model->createFor($data);

        return $lastId;
    }

    public static function slug($modelClassName, $data)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $text = $model->slug($data);

        return $text;
    }

    public static function update($modelClassName, $id, array $data)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $count = $model->update($id, $data);

        return $count;
    }

    public static function updateFor($modelClassName, $id, array $data)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $count = $model->updateFor($id, $data);

        return $count;
    }

    public static function delete($modelClassName, $id)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $count = $model->delete($id);

        return $count;
    }

    public static function softDelete($modelClassName, $id)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $count = $model->softDelete($id);

        return $count;
    }

    public static function restore($modelClassName, $id)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();
        $count = $model->restore($id);

        return $count;
    }

    public static function find($modelClassName, $id)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->find($id);
    }

    public static function where($modelClassName, $conditions = [], $operator = '=')
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->where($conditions, $operator);
    }

    public static function findSlug($modelClassName, $id)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->findSlug($id);
    }

    public static function findCmt($modelClassName, $id)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->findCmt($id);
    }

    public static function withTrashed($modelClassName)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->withTrashed();
    }

    public static function all($modelClassName, $order_by = 'ASC')
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->all($order_by);
    }

    public static function paginateWithTrashed($modelClassName, $page, $perPage)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->paginateWithTrashed($page, $perPage);
    }

    public static function paginate($modelClassName, $page, $perPage)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->paginate($page, $perPage);
    }

    public static function login($modelClassName, $email, $passowrd)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->login($email, $passowrd);
    }

    public static function sum($modelClassName, $field)
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->sum($field);
    }

    public static function sumWhere($modelClassName, $field, $conditions = [], $operator = '=')
    {

        $fullClassName = 'App\models\\' . $modelClassName;
        $model = new $fullClassName();

        return $model->sumWhere($field, $conditions, $operator);
    }
}
