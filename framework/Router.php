<?php

namespace Illuminate\framework;

use Illuminate\framework\factory\Route;

class Router
{
    public Request $request;
    public Response $response;
    protected $path = [];
    protected $callback = [];
    protected array $routes = [];
    protected array $routeGroups = [];


    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        Route::init($this);
    }

    public function group(array $attributes, \Closure $callback)
    {

        $this->routeGroups[] = $attributes;

        if ($this->routeGroups) {

            $prefix = $this->processGroupAttributes($attributes);

            $this->callback[] = null;
            $callback($this);

            foreach ($this->path as $key => $value) {
                unset($this->path[$key]);
                $this->path[] = $prefix . $value;
            }
        }
    }


    protected function processGroupAttributes(array $attributes): string
    {
        return isset($attributes['prefix']) ? rtrim($attributes['prefix'], '/') : '';
    }


    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
        $this->path[] = $path;
        $this->callback[] = $callback;
    }


    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
        $this->path[] = $path;
        $this->callback[] = $callback;
    }


    function isVariable($string)
    {
        $startChar = '{';
        $endChar = '}';
        $startCharLength = strlen($startChar);
        $endCharLength = strlen($endChar);

        if (substr($string, 0, $startCharLength) === $startChar && substr($string, -$endCharLength) === $endChar) {

            return true;
        }
    }

    public function getLastPath()
    {
        $param = '';

        foreach ($this->path as $url) {
            $pathInfo = $url;
            $segments = explode('/', $pathInfo);
            $param = end($segments);
            $param = rtrim($param, '/');

            if ($this->isVariable($param)) {
                return $param;
            }
        }

        return false;
    }

    public function resolve()
    {
        $path = $this->request->getPath();

        $hasVar = true;
        
        foreach ($this->path as $url) {

            if ($url == $path) {
                $path = $url;
                $hasVar = false;
                break;
            }
        }

        if ($hasVar) {
            $param = $this->request->getParam();
            $pathParam = $this->getLastPath();
            $path = str_replace($param, $pathParam, $path);
        }

        $method = $this->request->method();

        if ($this->routeGroups) {
            $firstPath = $this->routeGroups['0']['prefix'];
            $handlePath = str_replace($firstPath, '', $path);
            $callback = $this->routes[$method][$handlePath] ?? false;
        } else {
            $callback = $this->routes[$method][$path] ?? false;
        }  

        if (is_string($callback)) {

            return $this->renderView($callback);
        }

        if ($callback === false) {
            $this->response->setStatusCode(404);
            $pageError = "_404";

            return $this->renderOnlyView("$pageError");
        }

        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request);
    }


    function parseUrl($url)
    {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];
        preg_match('/\/(\d+)/', $path, $matches);
        $number = isset($matches[1]) ? $matches[1] : null;

        return $number;
    }


    public function renderView($view, $params = null)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

        if (file_exists('./resources/views/' . $view . '.php')) {
            return str_replace('{{content}}', $viewContent, $layoutContent);
        } else {
            ob_start();
            include_once Application::$ROOT_DIR . "/resources/views/layouts/error.php";
            $layoutContent = ob_get_clean();
            $layoutContent = str_replace('{{content}}', $viewContent, $layoutContent);
            return $layoutContent;
        }
    }


    protected function layoutContent()
    {
        $latout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/resources/views/layouts/$latout.php";

        return ob_get_clean();
    }


    protected function renderOnlyView($view, $params = null)
    {

        if ($params != null) {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/resources/views/$view.php";

        return ob_get_clean();
    }
}
