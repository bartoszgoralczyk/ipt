<?php

class router
{
    private $route;
    private $controller;
    private $action;
    private $params;
    
    public function __construct()
    {
        if (file_exists('app/config/routes.php'))
        {
            require_once ('app/config/routes.php');
        }
        $path = array_keys($_GET);
        $config = loader::load('config'); //load config 
        
        $route = isset($path[0]) ? $path[0] : $config->default_controller;
        
        $sanitzing_pattern = $config->allowed_url_chars;
        $route = preg_replace($sanitzing_pattern, '', $route);
        $route = str_replace("^", "", $route);
        $this->route = $route;
        $routeParts = preg_split("/\//", $route);
        $this->controller = $routeParts[0];
        
        $this->action = (isset($routeParts[1])) ? $routeParts[1] : $config->default_action;
        
        array_shift($routeParts);
        array_shift($routeParts);
        $this->params = $routeParts;
        
        if (isset($routes))
        {
            foreach ($routes as $_route)
            {
                $_pattern = "~{$_route[0]}~";
                $_destination = $_route[1];
                if (preg_match($_pattern, $route))
                {
                    $newrouteparts = preg_split("/\//", $_destination);
                    $this->controller = $newrouteparts[0];
                    $this->action = $newrouteparts[1];
                }
            }
        }
    }
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function getController()
    {
        return $this->controller;
    }
    
    public function getParams()
    {
        return $this->params;
    }
}