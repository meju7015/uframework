<?php
/**
 * 컨트롤러 클래스
 * 5.4 이하 버전용
 */
class Controller
{
    protected $model;
    protected $view;
    protected $user;

    public function __construct()
    {
        session_start();

        $this->user = $_SESSION;

        $this->model = new Model();
        $this->view = new View();
    }
}