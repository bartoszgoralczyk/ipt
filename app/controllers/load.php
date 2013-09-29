<?php

class load extends controller
{

    public $use_layout = false;
    public $accepted_css = array('bootstrap');

    public function index()
    {
        
    }

    public function css()
    {
        if (isset($this->params[0]))
        {
            switch ($this->params[0])
            {
                case 'bootstrap':
                    echo file_get_contents('c:/wamp/www/ipt/app/bootstrap/dist/css/bootstrap.css');
                    break;
            }
        }
        exit();
    }

    public function js()
    {
        if (isset($this->params[0]))
        {
            switch ($this->params[0])
            {
                case 'jquery':
                    echo file_get_contents('c:/wamp/www/ipt/app/bootstrap/assets/js/jquery.js');
                    break;
                case 'bootstrapmin':
                    echo file_get_contents('c:/wamp/www/ipt/app/bootstrap/dist/js/bootstrap.min.js');
                    break;
            }
        }
        exit();
    }

}
