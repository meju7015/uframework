<?php
require "app/configure/Static.php";
require "app/configure/Config.php";
require "app/configure/DBConfig.php";
require "app/libraries/Bootstrap.php";

$BootStrap = new BootStrap();

$BootStrap->wakeUp();