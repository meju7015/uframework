<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-20
 * Time: ¿ÀÈÄ 3:58
 */
$homeRouter = new Router($_SERVER, true);

$homeRouter
    ->get('/', 'home.index')
    ->get('/homes', 'home.homes')
    ->get('/blog', 'home.blog');

$homeRouter->run();