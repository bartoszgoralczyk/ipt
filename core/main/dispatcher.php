<?php

class dispatcher
{

    public static function dispatch($router)
    {
        global $app;
        // $cache = loader::load("cache");
        ob_start();
        $config = loader::load("config");
        if ($config->global_profile)
        {
            $start = microtime(true);
        }
        $controller = $router->getController();
        $action = $router->getAction();
        $params = $router->getParams();
        if (count($params) > 1)
        {
            if ($params[count($params) - 1] == "unittest" || $_POST['unittest'] == '1')
            {
                unittest::setUp();
            }
        }
        $controllerfile = "app/controllers/{$controller}.php";
        if (file_exists($controllerfile))
        {
            require_once($controllerfile);
            $app = new $controller();
            $app->setParams($params);
            $app->$action();
            
            unittest::tearDown();
            /*
            ob_end_clean();
            
            // Zarzadzanie widokiem.
            ob_start();
            $view = loader::load("view");
            $viewvars = $view->getVars($app);
            $uselayout = $config->use_layout;
            if (!$app->use_layout)
            {
                $uselayout = false;
            }
            $template = $view->getTemplate($action);
            base::_loadTemplate($controller, $template, $viewvars, $uselayout);
            if (isset($start))
            {
                echo "<p>Calkowity czas rozdzielenia:" . (microtime(true) - $start) . " sekund.</p>";
            }
            $output = ob_get_clean();
            // $cache->set("abcde", array("content"=>base64_encode($output)));
            echo $output;
            */
        }
        else
        {
            throw new Exception("Kontroler '{$controllerfile}' nie zostal znaleziony.");
        }
    }
}

