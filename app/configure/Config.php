<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-09-20
 * Time: ¿ÀÈÄ 1:18
 */
class Config
{
    const DEBUG                     = false;
    const APPLICATION_NAME          = 'uframework';
    const DEFAULT_SITE              = '/';
    const DEFAULT_TITLE             = 'uFramework';
    const DEFAULT_DESCRIPTION       = 'uFramework v1.0';
    const DEFAULT_THEME             = 'basic';
    const DEFAULT_TEMPLATE          = 'html';

    public static function getRootDir()
    {
        $thisFile = __FILE__;
        $explode = explode('app', $thisFile);

        return $explode[0];
    }
}