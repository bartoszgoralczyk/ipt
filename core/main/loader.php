<?php
class loader 
{
    private static $loaded = array();
    public static function load($object)
    {
        $valid = array('library','view','model','helper','router','config','hook','cache','db');
        if (!in_array($object, $valid))
        {
            $config = self::load('config');
            if ($config->debug == 'on')
            {
                base::backtrace();
            }
            throw new Exception("Brak poprawnego obiektu '{$object}' do wczytania");
        }
        if (empty(self::$loaded[$object]))
        {
            self::$loaded[$object] = new $object();
        }
        return self::$loaded[$object];
    }
}