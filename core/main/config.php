<?php

class config
{
    private $config;
    function __construct()
    {
        global $configs;
        include_once ('core/config/configs.php');
        include_once ('app/config/configs.php');
        $this->config = $configs;
    }
    function __get($var)
    {
        return $this->config[$var];
    }

}
