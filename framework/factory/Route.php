<?php

namespace Illuminate\framework\factory;

use Illuminate\framework\Router;

class Route
{
    protected static $router;

    public static function init(Router $router)
    {
        self::$router = $router;
    }
    
    public static function get($path, $callback)
    {
        self::$router->get($path, $callback);
    }

    public static function post($path, $callback)
    {
        self::$router->post($path, $callback);
    }

    public static function group($attributes, $callback)
    {
        self::$router->group($attributes, $callback);
    }
}
