<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-19
 * Time: ¿ÀÈÄ 5:49
 */
class BootStrap
{
    protected $rootDir;

    public function __construct()
    {
        $this->rootDir = Config::getRootDir();
        DBConfig::setDatabaseInfo(LOCAL_CHANEL);
    }

    private function loadRouter()
    {
        $routerPath = $this->rootDir."routes/";
        $routes = array_diff(scandir($routerPath), array('.', '..'));

        foreach ($routes as $key => $item) {
            if (strpos($item, '.php') === false) {
                continue;
            }

            include_once $routerPath.$item;
        }


        Router::run($_SERVER, false);
    }

    private function autoLoad()
    {
        /**
         * do not change index
         */
        $path = Array(
            "app/interface/",
            "app/exceptions/",
            "app/core/",
            "app/libraries/",
            "app/controllers/",
            "app/models/"
        );

        foreach ($path as $key => $item) {
            $loader = array_diff(scandir($this->rootDir.$item), Array('.', '..'));
            foreach ($loader as $file) {
                if (strpos($file, '.php') === false) {
                    continue;
                }

                $filePath = $this->rootDir.$item.$file;

                include_once $filePath;
            }
        }

        return $this;
    }

    public function wakeUp()
    {
        $this
            ->autoLoad()
            ->loadRouter();
    }
}