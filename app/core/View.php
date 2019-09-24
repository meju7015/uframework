<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-19
 * Time: 오후 5:49
 */
class View
{
    /**
     * View Codes
     *
     * @var
     */
    protected $view;

    /**
     * Html header
     *
     * @var array
     */
    protected $head;

    /**
     * Extract data
     *
     * @var
     */
    protected $data;

    /**
     * Theme directory
     *
     * @var string
     */
    protected $theme;

    /**
     * Template extension (default html)
     *
     * @var string
     */
    protected $template;

    /**
     * 절대경로
     * 
     * @var 
     */
    protected $rootDir;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->theme = Config::DEFAULT_THEME;
        $this->template = Config::DEFAULT_TEMPLATE;
        $this->rootDir = Config::getRootDir();

        $this->head = Array(
            'title' => Config::APPLICATION_NAME,
            'meta'  => Array(
                'description' => Config::DEFAULT_DESCRIPTION
            ),
            'js' => Array(
                'jquery' => '/js/jquery/jquery-3.4.1.min.js',
                'bootstrap' => '/js/bootstrap/bootstrap.bundle.js'
            ),
            'css' => Array(
                'bootstrap' => '/css/bootstrap/bootstrap.min.css'
            )
        );

        $this->data = Array(
            'head' => $this->head,
            'session' => ''
        );
    }

    /**
     * 뷰 로드
     * 
     * @param string    $view
     * @param string    $endPoint
     * @param array     $data
     * @return false|string
     * @throws ViewException
     */
    public function loadView($view, $endPoint, $data = null)
    {
        $view = strtolower($view);

        $viewFile = "{$this->rootDir}/resources/views/{$this->theme}/{$view}/{$endPoint}.{$this->template}";

        if (file_exists($viewFile)) {
            ob_start();

            extract($this->data);

            if (is_array($data)) {
                extract($data);
            }

            include_once $viewFile;
            $this->view[] =  ob_get_clean();

            return $this;
        } else {
            throw new ViewException('뷰 파일을 찾을 수 없습니다. EndPoint 를 확인하세요.', 405);
        }
    }

    public function display()
    {
        print(join($this->view));
    }
}