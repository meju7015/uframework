<?php

class Router
{
    private static $request;
    private static $routes = Array();
    private static $arguments = Array();
    private static $debug = false;
    private static $rootDir;

    public static function setDebug($level, $debug = true)
    {
        self::$debug = $debug;
        error_reporting($level);
    }

    private static function parseRequest($subRoot, Array $request)
    {
        self::$rootDir = $request['DOCUMENT_ROOT'].$subRoot;
        return str_replace($subRoot, '', $request['REQUEST_URI']);
    }

    private static function parseUri($uri)
    {
        return $uri;
    }

    private static function hasRoute($uri = '/')
    {
        $requestList = explode('/', $uri);

        for ($i = 0; $i < sizeof($requestList); $i++) {
            if (empty($requestList[$i])) {
                continue;
            }

            $slice = array_slice($requestList, 0, sizeof($requestList) - $i);
            $sliceString = implode('/', $slice);

            if (!empty($sliceString[0]) && $sliceString[0] !== '/') {
                $sliceString = '/'.$sliceString;
            }

            if ($key = array_key_exists($sliceString, self::$routes)) {
                for ($q = (int)$key; $q < sizeof($requestList); $q++) {
                    if (empty($requestList[$q])) continue;

                    self::$arguments[] = $requestList[$q];
                }

                return self::$routes[$sliceString];
            }
        }

        if (array_key_exists($uri, self::$routes)) {
            return self::$routes[$uri];
        }

        return false;
    }

    public static function run(Array $request, $debug = false)
    {
        self::$rootDir = Config::getRootDir();

        if (isset($request['REQUEST_URI'])) {
            self::$request = $request['REQUEST_URI'];
            self::$debug = $debug;
        } elseif (empty(self::$request) && isset($request['argv'])) {
            self::$request = $request['argv'][1];
        }

        if ($debug === true) {
            self::setDebug(E_ALL);
        } else {
            self::setDebug(E_ERROR);
        }

        UDebug::store(self::$routes, 'routes');

        if ($router = self::hasRoute(self::$request)) {
            $controllerArguments = explode('.', $router['controller']);

            if (file_exists(self::$rootDir . "app/controllers/{$controllerArguments[0]}.php")) {
                if ($router['method'] != 'command' && strtoupper($router['method']) !== strtoupper($_SERVER['REQUEST_METHOD'])) {
                    throw new RouteException('Not found methods', 405);
                }

                $methodArgument = $_GET;

                switch ($router['method']) {
                    case OAUTH_HTTP_METHOD_GET :
                        $methodArgument = $_GET;
                        break;
                    case OAUTH_HTTP_METHOD_POST :
                        $methodArgument = $_POST;
                        break;
                    case METHOD_COMMAND :
                        $methodArgument = $_SERVER['argv'];
                        break;
                }

                $controller = new $controllerArguments[0];

                if (method_exists($controller, $controllerArguments[1])) {
                    UDebug::store($router, 'router')
                        ->store($methodArgument, $router['method'])
                        ->store(
                            Array(
                                'controller' => $controllerArguments[0],
                                'func' => $controllerArguments[1],
                                'path' => self::$rootDir . "app/controllers/{$controllerArguments[0]}.php"
                            ),
                            'controller'
                        );

                    $controller->{$controllerArguments[1]}($methodArgument, self::$arguments);
                } else {
                    throw new RouteException('Not found methods', 405);
                }
            } else {
                throw new RouteException('Controller Class를 찾을수 없습니다.', 405);
            }
        } else {
            throw new RouteException('Blank page', 405, '페이지가 존재하지 않습니다.');
        }
    }

    public static function get($uri, $controller)
    {
        $parseUri = self::parseUri($uri);

        self::$routes[$parseUri] = Array(
            'method' => 'get',
            'controller' => $controller
        );

        return new static;
    }

    public static function post($uri, $controller)
    {
        $parseUri = self::parseUri($uri);

        self::$routes[$parseUri] = Array(
            'method' => 'post',
            'controller' => $controller
        );

        return new static;
    }

    public static function command($target, $controller)
    {
        self::$routes[$target] = Array(
            'method' => 'command',
            'controller' => $controller
        );

        return new static;
    }
}