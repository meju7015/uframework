<?php
/**
 * ¶ó¿ìÆ® Exception
 */
class RouteException extends Exception implements Exceptions
{
    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);

        if (Config::DEBUG && $this->getCode() === 404) {
            $this->loadMain();
        }

        $this->display();
    }

    public function display()
    {
        $view = new View();
        $view->loadView(
            'exception',
            $this->getCode(),
            Array(
                'msg' => $this->getMessage()
            )
        )->display();
        exit;
    }

    public function loadMain()
    {
        header('Location:'.Config::DEFAULT_SITE);
        exit;
    }
}