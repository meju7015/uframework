<?php
/**
 * ��Ʈ�ѷ� Ŭ����
 * 5.4 ���� ������
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