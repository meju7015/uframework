<?php
/**
 * ºä Exception
 */
class ViewException extends Exception implements Exceptions
{
    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);

        if ($this->getCode() === 404) {
            $this->loadMain();
        }

        $this->display();
    }

    public function display()
    {
        echo "<pre style='position:relative; top:0; z-index:999999; background: black;color: greenyellow'>";
        print_r($this->getMessage());
        echo "</pre>";
        exit;
    }

    public function loadMain()
    {
        header('Location:'.Config::DEFAULT_SITE);
        exit;
    }
}