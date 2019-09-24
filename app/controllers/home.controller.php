<?php
/**
 * 사용자 정의 컨트롤러
 */
class Home extends Controller implements Controllable
{
    public function index($request, $params)
    {
        $viewData = Array(
            'test' => 'test'
        );

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