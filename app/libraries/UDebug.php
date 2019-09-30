<?php

/**
 * Class UDebug
 */
class UDebug
{
    public static $trace;

    public static function store(Array $data, $key = null)
    {
        if ($key !== null) {
            self::$trace[$key] = $data;
        } else {
            self::$trace[] = $data;
        }
    }

    public static function pop()
    {
        return self::$trace;
    }

    public static function display()
    {
        echo '<pre style="position:relative; width:100%; top:0; height: 300px; padding:10px; background-color:#282828; color:greenyellow; z-index:9999">';
        print_r(self::$trace);
        echo '</pre>';
    }
}