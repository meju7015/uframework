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

        if ($debug === true) {
            $this->setDebug();
        }
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
        $this->routes[$parseUri] = Array(
            'method'     => 'get',
            'controller' => $controller
        );

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
     * 컨트롤러 실행
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
                    throw new RouteException('Method 를 찾을 수 없습니다.', 405);
                }
            } else {
                throw new RouteException('Controller class 를 찾을 수 없습니다.', 405);
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