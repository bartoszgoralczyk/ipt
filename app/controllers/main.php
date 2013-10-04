<?php

class main extends controller
{
    public $template;
    public $layout;
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->layout = 'std';
        $this->template = 'index';
    
    }

}
