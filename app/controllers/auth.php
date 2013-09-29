<?php
session_start();
class auth extends controller
{
   public $use_layout = false;
   function index()
   {
   }
   public function login()
   {
      // $this->redirect("auth");
      $this->view->set("message","");
      if(!empty($_SESSION['userid']))
      {
         $this->redirect("blog","display");
      }
      else if (!empty($_POST))
      {
         $user = $this->model->user;
         $userdata = $user->find(array("name"=>$user->name,
            "password"=>md5($user->password)));
         if (!$userdata)
         {
            // Nie znaleziono.
            $this->view->set("message","Bledna nazwa uzytkownika lub haslo.");
         }
         else
         {
            $_SESSION['userid']=$userdata['id'];
            $this->redirect("blog","display");
         }
      }
   }
   public function register()
   {
      if(!empty($_POST))
      {
         $user = $this->model->user;
         if (!$user->find(array("name"=>$user->name)))
         {
            $user->password = md5($user->password);
            $user->insert();
         }
      }
   }
}