<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-20
 * Time: ¿ÀÈÄ 3:58
 */
$homeRouter = new Router($_SERVER, true);

$homeRouter
    ->get('/', 'HomeController.index')
    ->get('/homes', 'HomeController.homes')
    ->get('/blog', 'HomeController.blog');

$homeRouter->run();