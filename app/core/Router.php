<?php
/**
 * ����� Ŭ����
 * 5.4 ���� ������
 */
class Router
{
    /**
     * SERVER ����
     * 
     * @var array 
     */
    public $request;

    /**
     * ���ǵ� ����� ����Ʈ
     * 
     * @var array 
     */
    public $routes = Array();

    /**
     * ���Ʈ Arguments
     * 
     * @var array 
     */
    public $argv = Array();

    /**
     * ������丮 ����
     * 
     * @var bool 
     */
    public $isSubDirectory = false;

    /**
     * ����� ����
     * 
     * @var bool 
     */
    public $debug = false;

    /**
     * �ֻ��� ��Ʈ
     * 
     * @var string
     */
    public $rootDir;

    /**
     * Router constructor.
     *
     * @param array $request
     * @param boolean $debug
     */
    public function __construct(Array $request, $debug = false)
    {
        $this->rootDir = Config::getRootDir();
        $this->request = $request['REQUEST_URI'];
        $this->debug = $debug;

        if ($debug === true) {
            $this->setDebug();
        }
    }

    /**
     * ����� ����
     */
    public function setDebug()
    {
        $this->debug = true;
        error_reporting(E_ALL);
    }

    /**
     * �����ӿ�ũ�� ���굵���� ������ �����Ұ��
     * �ش� �Լ��� �̿��Ͽ� request �� �Ľ��Ұ�.
     *
     * @param string    $subRoot
     * @param array     $request
     *
     * @return mixed(string|array)
     */
    private function parseRequest($subRoot, Array $request)
    {
        $this->isSubDirectory = true;
        $this->rootDir = $request['DOCUMENT_ROOT'].$subRoot;
        return str_replace($subRoot, '', $request['REQUEST_URI']);
    }

    /**
     * URI �ļ�
     *
     * @param string $uri
     * @return bool|string
     */
    private function parseUri($uri)
    {
        return $uri;
    }

    /**
     * ����� ���
     *
     * @param string    $uri
     * @param string    $controller
     * @return Object   $this
     */
    public function addRoute($uri, $controller)
    {
        $parseUri = $this->parseUri($uri);
        $this->routes[$parseUri] = Array(
            'method'     => 'get',
            'controller' => $controller
        );

        return $this;
    }

    /**
     * ��ϵ� ����� Ȯ��.
     *
     * @param $uri
     * @return bool|int|string
     */
    public function hasRoute($uri = '/')
    {
        $requestList = explode('/', $uri);

        for ($i = 0; $i < sizeof($requestList); $i++) {

            $slice = array_slice($requestList, 0, sizeof($requestList)-$i);
            $sliceString = implode('/', $slice);

            if ($sliceString[0] !== '/') {
                $sliceString = '/'.$sliceString;
            }

            if ($key = array_key_exists($sliceString, $this->routes)) {
                for ($q = (int)$key; $q < sizeof($requestList); $q++) {
                    $this->argv[] = $requestList[$q];
                }

                return $this->routes[$sliceString];
            }
        }

        return false;
    }

    /**
     * ��Ʈ�ѷ� ����
     */
    public function run()
    {
        if ($router = $this->hasRoute($this->request)) {
            $split = explode('.', $router['controller']);

            if (file_exists($this->rootDir."/app/controllers/{$split[0]}.php")) {
                include_once $this->rootDir."/app/controllers/{$split[0]}.php";

                if (strtoupper($router['method']) !== $_SERVER['REQUEST_METHOD']) {
                    throw new RouteException('not found method', 405);
                }

                $methodArgv = $_GET;

                switch ($router['method']) {
                    case OAUTH_HTTP_METHOD_GET :
                        $methodArgv = $_GET;
                        break;
                    case OAUTH_HTTP_METHOD_POST :
                        $methodArgv = $_POST;
                        break;
                }

                $controller = new $split[0];
                if (method_exists($controller, $split[1])) {
                    $controller->$split[1]($methodArgv, $this->argv);
                } else {
                    throw new RouteException('Method �� ã�� �� �����ϴ�.', 405);
                }
            } else {
                throw new RouteException('Controller class �� ã�� �� �����ϴ�.', 405);
            }
        }
    }

    public function get($uri, $controller)
    {
        $parseUri = $this->parseUri($uri);

        $this->routes[$parseUri] =  Array(
            'method'     => 'get',
            'controller' => $controller
        );

        return $this;
    }

    public function post($uri, $controller)
    {
        $parseUri = $this->parseUri($uri);

        $this->routes[$parseUri] = Array(
            'method'     => 'post',
            'controller' => $controller
        );
    }

    public function put()
    {

    }

    public function delete()
    {

    }

    public function option()
    {

    }
}