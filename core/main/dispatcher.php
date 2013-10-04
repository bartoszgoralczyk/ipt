<?php

class dispatcher
{
    public static function dispatch($router)
    {
        $controller = $router->getController();
        $action = 
        $controllerfile = "app/controllers/{$controller}.php";
        if (file_exists($controllerfile))
        {
            require_once($controllerfile);
            $app = new $this->controller();
            $app->setParams($this->params);
            if (method_exists($app, $this->action))
            {
                $app->{$this->action}();
            }
            else
            {
                throw new Exception("Metoda '{$athis->ction}' nie zostala znaleziona.");
            }
            
            $view = loader::load("view");
            $view->render();
        }
        else
        {
            throw new Exception("Kontroler '{$controllerfile}' nie zostal znaleziony.");
        }
    }
}

