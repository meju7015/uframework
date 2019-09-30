<?php

/**
 * 사용자 정의 컨트롤러
 */
class HomeController extends Controller implements Controllable
{
    public function index($request, $params)
    {
        $viewData = Array(
            'test' => 'test'
        );

        $HomeModel = $this->model->loadModel('HomeModel');
        $HomeModel->selectUsers('root');

        $this->view
            ->loadView('home', 'index', $viewData)
            ->display();
    }

    public function homes($request, $params)
    {
        $this->view
            ->loadView('home', 'home')
            ->display();
    }
}