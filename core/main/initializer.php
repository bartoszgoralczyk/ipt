<?php

class initializer 
{
    public static function initialize()
    {
        set_include_path(get_include_path().PATH_SEPARATOR."core/main");
        set_include_path(get_include_path().PATH_SEPARATOR."core/main/cache");
        set_include_path(get_include_path().PATH_SEPARATOR."core/helpers");
        set_include_path(get_include_path().PATH_SEPARATOR."core/libraries");
        set_include_path(get_include_path().PATH_SEPARATOR."core/models");
        set_include_path(get_include_path().PATH_SEPARATOR."core/views");
    }

}