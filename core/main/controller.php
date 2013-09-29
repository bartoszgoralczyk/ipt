<?php

class controller
{
    public $view;
    public $model;
    public $params;
    function __construct()
    {
        $this->view = loader::load("view");
        //$this->db = loader::load("db");
    }
    public function setParams($params)
    {
        $this->params = $params;
    }
}