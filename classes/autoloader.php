<?php

class AutoLoader
{

    function __construct()
    {
        spl_autoload_register(array($this, 'classAutoLoad'));
    }

    public function classAutoLoad($className)
    {
        $path =  __DIR__.DIRECTORY_SEPARATOR.$className.'.php';
        if(is_readable($path))
        {
            require_once $path;
        }
    }
}
