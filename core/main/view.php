<?php

class view
{
    private $vars = array();
    private $template;
    private $layout;
    private $output;
    public $controller;
    private $templatecontent;
    
    function __construct()
    {
        $this->vars['baseurl'] = base::baseUrl();
    }
    
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
    
    public function setController($controller)
    {
        $this->controller = $controller;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    public function getTemplate()
    {
        $this->templatecontent = file_get_contents('c:/wamp/www/ipt/app/views/' . get_class($this->controller) . '/' . $this->controller->template . '.php');
    }
    
    function __get($var)
    {
        return loader::load($var);
    }
    
    function setLayout()
    {
        $this->layout = $this->controller->layout;
    }
    function getLayout()
    {
        $this->output = file_get_contents('c:/wamp/www/ipt/app/views/layouts/' . $this->controller->layout . '.html');
    }
    
    function parse($vars = array())
    {
        foreach ($vars as $key => $value)
        {
            $this->output = str_replace('{' . $key . '}', $value, $this->output);
        }
        
    }
    
    function render($controller)
    {
        $this->setController($controller);
        $this->getLayout();
        $this->getTemplate();
        $this->parse(array('headbegin' => '', 'headend' => '', 'bodybegin' => '', 'bodyend' => '', 'title' => '', 'container' => $this->templatecontent));
        
        $this->parse($this->vars);
        
        echo $this->output;
    }
}