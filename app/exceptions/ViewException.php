<?php

/**
 * ºä Exception
 */
class ViewException extends Exception implements Exceptions
{
    protected $hint;

    public function __construct($message = "", $code = 0, $hint = "")
    {
        parent::__construct($message, $code);

        $this->hint = $hint;

        if (Config::DEBUG && $this->getCode() === 404) {
            $this->loadMain();
        }

        $this->display();
    }

    public function getHint()
    {
        return $this->hint;
    }

    public function display()
    {
        $view = new View();
        $view->loadView(
            'exception',
            $this->getCode(),
            Array(
                'msg'   => $this->message,
                'code'  => $this->code,
                'trace' => $this->getTrace(),
                'hint'  => $this->hint
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