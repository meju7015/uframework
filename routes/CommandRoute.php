<?php
$CommandRoute = new Router($_SERVER, true);

$CommandRoute->command('make:controller', 'MakeController.makeController');


