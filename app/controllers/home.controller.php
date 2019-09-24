<?php
/**
 * 사용자 정의 컨트롤러
 */
class Home extends Controller
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
}