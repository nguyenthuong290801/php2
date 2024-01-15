<?php

namespace Illuminate\framework\factory;

use Illuminate\framework\Schema as SchemaMain;

class Schema
{
    public static function create($table, $callback)
    {
        $schemaMain = new SchemaMain();
        $schemaMain->create($table, $callback);
    }

    public static function update($table, $callback)
    {
        $schemaMain = new SchemaMain();
        $schemaMain->update($table, $callback);
    }

    public static function dropIfExists($table)
    {
        $schemaMain = new SchemaMain();
        $schemaMain->dropIfExists($table);
    }
}