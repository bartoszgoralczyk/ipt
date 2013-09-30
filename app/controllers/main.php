<?php

class main extends controller
{
    function __construct()
    {
        parent::__construct();
        $this->view->setLayout('std');
        $this->view->controller = 'main';
    }
    
    public function index()
    {
        $this->view->setTemplate('index');
    
        $this->view->set("baseurl", base::baseUrl());
        $this->view->render();
    }

}
