<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-19
 * Time: ¿ÀÈÄ 5:37
 */
class Home extends Controller
{
    public function index()
    {
        $viewData = Array(
            'test' => 'test'
        );

        $this->view
            ->loadView('home', 'index', $viewData)
            ->display();
    }
}