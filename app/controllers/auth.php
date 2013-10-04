<?php

session_start();

class auth extends controller
{

    function __construct()
    {
        parent::__construct();
        $this->view->setLayout('std');
        $this->view->controller = 'auth';
    }

    function index()
    {
        
    }

    public function login()
    {
        $this->view->setTemplate('login');

        $this->view->render();
    }

    public function loginDo()
    {
        if (isset($this->params['email']) AND !empty($this->params['email']) AND isset($this->params['email']) AND !empty($this->params['email']))
        {
            $this->db = loader::load('db');
            $this->db->execute("SELECT * FROM users");
            $row = $this->db->getRows();
        }
        else
        {
            $this->redirect('main');
        }
    }

    public function aalogin()
    {
        // $this->redirect("auth");
        $this->view->set("message", "");
        if (!empty($_SESSION['userid']))
        {
            $this->redirect("blog", "display");
        }
        else if (!empty($_POST))
        {
            $user = $this->model->user;
            $userdata = $user->find(array("name" => $user->name,
                "password" => md5($user->password)));
            if (!$userdata)
            {
                // Nie znaleziono.
                $this->view->set("message", "Bledna nazwa uzytkownika lub haslo.");
            }
            else
            {
                $_SESSION['userid'] = $userdata['id'];
                $this->redirect("blog", "display");
            }
        }
    }

    public function register()
    {
        if (!empty($_POST))
        {
            $user = $this->model->user;
            if (!$user->find(array("name" => $user->name)))
            {
                $user->password = md5($user->password);
                $user->insert();
            }
        }
    }

    public function logout()
    {
        
    }

}
