<?php

Router::get('/', 'HomeController.index')
    ->get('/home', 'HomeController.homes');

Router::post('/login', 'HomeController.login');