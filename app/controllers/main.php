<?php

class main extends controller
{
    
    public function index()
    {
        $config = loader::load("config");
        $this->view->set("baseurl", base::baseUrl());
    }

}
