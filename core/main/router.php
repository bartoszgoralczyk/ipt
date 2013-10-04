<?php

class Router
{
    private $route;
    private $controller;
    private $action;
    private $params;
    private $requestType;
    
    public function __construct()
    {
        $path = array();
        $this->getRequestType();
        
        if ($this->requestType == 'get' OR $this->requestType == 'post')
        {
            $path = array_keys($_GET);
        }
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
        if ($this->requestType == 'post')
        {
            $this->params = array_merge($_POST, $this->params);
        }
    }
    
    public function dispatch()
    {
        $controllerfile = "app/controllers/{$this->controller}.php";
        if (file_exists($controllerfile))
        {
            require_once($controllerfile);
            $controller = new $this->controller();
            $controller->setParams($this->params);
            if (method_exists($controller, $this->action))
            {
                $controller->{$this->action}();
            }
            else
            {
                throw new Exception("Metoda '{$athis->ction}' nie zostala znaleziona.");
            }
            
            $view = loader::load("view");
            $view->render($controller);
        }
        else
        {
            throw new Exception("Kontroler '{$controllerfile}' nie zostal znaleziony.");
        }
    }
    
    public function getRequestType()
    {
        $req = strtolower($_SERVER['REQUEST_METHOD']);
        switch ($req)
        {
            case 'get':
                $this->requestType = $req;
                break;
            case 'post':
                $this->requestType = $req;
                break;
            default:
                $this->requestType = 'get';
                break;
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