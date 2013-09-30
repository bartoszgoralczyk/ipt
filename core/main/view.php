<?php

class view
{
    private $vars = array();
    private $template;
    private $layout;
    private $output;
    public $controller;
    private $templatecontent;
    
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
    
    public function getTemplate()
    {
        $this->templatecontent = file_get_contents('c:/wamp/www/ipt/app/views/' . $this->controller . '/' . $this->template . '.php');
    }
    
    function __get($var)
    {
        return loader::load($var);
    }
    
    function setLayout($layout)
    {
        $this->layout = $layout;
    }
    function getLayout()
    {
        $this->output = file_get_contents('c:/wamp/www/ipt/app/views/layouts/' . $this->layout . '.html');
    }
    
    function parse($vars = array())
    {
        foreach ($vars as $key => $value)
        {
            $this->output = str_replace('{' . $key . '}', $value, $this->output);
        }
        
    }
    
    function render()
    {
        $this->getLayout();
        $this->getTemplate();
        $this->parse(array('headbegin' => '', 'headend' => '', 'bodybegin' => '', 'bodyend' => '', 'title' => '', 'container' => $this->templatecontent));
        
        $this->parse($this->vars);
        
        echo $this->output;
    }
}