<?php
$CommandRoute = new Router($_SERVER, false);

$CommandRoute
    ->command('make:controller', 'MakeController.makeController')
    ->command('make:model', 'MakeController.makeModel');

$CommandRoute->run();
