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

        if (isset($request['REQUEST_URI'])) {
            $this->request = $request['REQUEST_URI'];
            $this->debug = $debug;
        } elseif (empty($this->request) && isset($request['argv'])) {
            $this->request = $request['argv'][1];
        }

        if ($debug === true) {
            $this->setDebug(E_ALL);
        } else {
            $this->setDebug(E_ERROR);
        }
    }

    /**
     * 디버깅 세팅
     */
    public function setDebug($level)
    {
        $this->debug = true;
        error_reporting($level);
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

            $slice = array_slice($requestList, 0, sizeof($requestList) - $i);
            $sliceString = implode('/', $slice);

            if ($sliceString[0] !== '/') {
                $sliceString = '/' . $sliceString;
            }

            if ($key = array_key_exists($sliceString, $this->routes)) {
                for ($q = (int)$key; $q < sizeof($requestList); $q++) {
                    $this->argv[] = $requestList[$q];
                }

                return $this->routes[$sliceString];
            }
        }

        // 커맨드로 접근할때. 예외처리.
        if (array_key_exists($uri, $this->routes)) {
            return $this->routes[$uri];
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

            if (file_exists($this->rootDir."app/controllers/{$split[0]}.php")) {

                if (strtoupper($router['method']) !== strtoupper($_SERVER['REQUEST_METHOD'])) {
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
                    case 'command' :
                        $methodArgv = $_SERVER['argv'];
                        break;
                }

                $controller = new $split[0];

                if (method_exists($controller, $split[1])) {

                    UDebug::store($router, 'router')
                        ->store($methodArgv, $router['method'])
                        ->store(Array(
                            'controller' => $split[0],
                            'func' => $split[1],
                            'path' => $this->rootDir."/app/controllers/{$split[0]}.php"
                        ), 'controller');

                    $controller->$split[1]($methodArgv, $this->argv);
                } else {
                    throw new RouteException('Method 를 찾을 수 없습니다.', 405);
                }
            } else {
                throw new RouteException('Controller class 를 찾을 수 없습니다.', 405);
            }
        }
    }

    /**
     * GET 요청 라우터 생성
     *
     * @param $uri
     * @param $controller
     * @return $this
     */
    public function get($uri, $controller)
    {
        $parseUri = $this->parseUri($uri);

        $this->routes[$parseUri] =  Array(
            'method'     => 'get',
            'controller' => $controller
        );

        return $this;
    }

    public function command($target, $controller)
    {
        $this->routes[$target] = Array(
            'method'     => 'command',
            'controller' => $controller
        );

        $_SERVER['REQUEST_METHOD'] = 'command';

        return $this;
    }

    /**
     * POST 요청 라우터 생성
     *
     * @param $uri
     * @param $controller
     */
    public function post($uri, $controller)
    {
        $parseUri = $this->parseUri($uri);

        $this->routes[$parseUri] = Array(
            'method'     => 'post',
            'controller' => $controller
        );
    }

    /**
     * PUT 요청 라우터 생성
     * (필요에 따라 구현하여 사용.)
     */
    public function put()
    {

    }

    /**
     * PUT 요청 라우터 생성
     * (필요에 따라 구현하여 사용.)
     */
    public function delete()
    {

    }

    /**
     * PUT 요청 라우터 생성
     * (필요에 따라 구현하여 사용.)
     */
    public function option()
    {

    }
}