<?php
/**
 * ����� ���� ��Ʈ�ѷ�
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