<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-19
 * Time: ¿ÀÈÄ 5:37
 */
class Home extends Controller
{
    public function index($params)
    {
        $viewData = Array(
            'test' => 'test'
        );

        echo $params;

        $this->view
            ->loadView('home', 'index', $viewData)
            ->display();
    }
}