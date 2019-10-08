<?php

Router::command('make:controller', 'MakeController.makeController')
    ->command('make:model', 'MakeController.makeModel')
    ->command('make:router', 'MakeController.makeRouter')
    ->command('make:all', 'MakeController.makeAll');