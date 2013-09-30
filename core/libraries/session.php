<?php

class session
{

    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    public static function get($name)
    {
        return $_SESSION[$name];
    }
    
    public static function start()
    {
        session_start();
    }

}