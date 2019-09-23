<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-20
 * Time: ¿ÀÈÄ 3:58
 */
$homeRouter = new Router($_SERVER);

$homeRouter
    ->addRoute('/', 'home.index')
    ->run();