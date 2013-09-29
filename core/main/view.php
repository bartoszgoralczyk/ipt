<?php

class view
{
    private $vars = array();
    private $template;
    
    public function set($key, $value)
    {
        $this->vars[$key] = $value;
    }
    
    public function getVars(&$controller=null)
    {
        if (!empty($controller))
        {
            $this->vars['app'] = $controller;
        }
        return $this->vars;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    public function getTemplate(&$controller=null)
    {
        if (empty($this->template))
        {
            return $controller;
        }
        return $this->template;
    }
    
    function __get($var)
    {
        return loader::load($var);
    }
}