<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-20
 * Time: ���� 3:58
 */
$homeRouter = new Router($_SERVER);

$homeRouter
    ->get('/', 'home.index')
    ->get('/home', 'home.home')
    ->get('/blog', 'home.blog');

$homeRouter->run();