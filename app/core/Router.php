<?php
/**
 * 라우팅 클래스
 * 5.4 이하 버전용
 */
class Router
{
    /**
     * SERVER 변수
     * 
     * @var array 
     */
    public $request;

    /**
     * 정의된 라우터 리스트
     * 
     * @var array 
     */
    public $routes = Array();

    /**
     * 라우트 Arguments
     * 
     * @var array 
     */
    public $argv = Array();

    /**
     * 서브디렉토리 여부
     * 
     * @var bool 
     */
    public $isSubDirectory = false;

    /**
     * 디버깅 여부
     * 
     * @var bool 
     */
    public $debug = false;

    /**
     * 최상위 루트
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
    }

    /**
     * 디버깅 세팅
     */
    public function setDebug()
    {
        $this->debug = true;
        error_reporting(E_ALL);
    }

    /**
     * 프레임워크가 서브도메인 하위에 존재할경우
     * 해당 함수를 이용하여 request 를 파싱할것.
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
     * URI 파서
     *
     * @param string $uri
     * @return bool|string
     */
    private function parseUri($uri)
    {
        /*$roots = explode('/', $uri);
        $request = explode('/', $this->request);
        $indexOf = strpos($uri, '{');

        print_r($request);


        if ($indexOf !== false) {
            $split = substr($uri, 0, $indexOf);
            $uri = substr($split, 0, strlen($split)-1);
        }


        if (substr($uri, strlen($uri)-1, 1) === '/' && strlen($uri) > 1) {
            $uri = substr($uri, 0, sizeof($uri)-1);
        }

        foreach ($roots as $key => $item) {
            if (strpos($item, '{') !== false) {
                $this->argv[$key] = $request[$key];
            }
        }*/

        return $uri;
    }

    /**
     * 라우터 등록
     *
     * @param string    $uri
     * @param string    $controller
     * @return Object   $this
     */
    public function addRoute($uri, $controller)
    {
        $parseUri = $this->parseUri($uri);
        $this->routes[$parseUri] =  $controller;

        return $this;
    }

    /**
     * 등록된 라우터 확인.
     *
     * @param $uri
     * @return bool|int|string
     */
    public function hasRoute($uri = '/')
    {
        $argv = Array();
        $requestList = explode('/', $uri);

        for ($i = sizeof($requestList); $i > 0; $i--) {

            $slice = array_slice($requestList, sizeof($requestList)-$i);

            print_r($slice);

            if (array_key_exists('/'.$requestList[$i], $this->routes)) {

            }
        }

        return array_key_exists($uri, $this->routes);
    }

    /**
     * 컨트롤러 실행
     */
    public function run()
    {
        print_r($this->routes);

        if ($this->hasRoute($this->request)) {
            $split = explode('.', $this->routes[$this->request]);

            if (file_exists($this->rootDir."/app/controllers/{$split[0]}.controller.php")) {
                include_once $this->rootDir."/app/controllers/{$split[0]}.controller.php";

                $controller = new $split[0];
                if (method_exists($controller, $split[1])) {
                    $controller->$split[1]($this->argv);
                } else {
                    throw new RouteException('not found method', 405);
                }
            } else {
                throw new RouteException('not found class', 405);
            }
        }
    }
}