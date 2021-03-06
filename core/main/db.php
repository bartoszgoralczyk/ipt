<?php
include_once("dbdrivers/abstract.dbdriver.php");
class db
{
   private $dbengine;
   private $state  = "development";
   public function __construct()
   {
      $config = loader::load("config");
      $dbengineinfo = $config->db;
      if (!$dbengineinfo['usedb']==false)
      {
         $driver = $dbengineinfo[$this->state]['dbtype'].'driver';
         include_once("dbdrivers/{$driver}.php");
         $dbengine = new $driver($dbengineinfo[$this->state]);
         $this->dbengine = $dbengine;
      }
   }
   public function setDbState($state)
   {
      // Wartoœci¹ musi byæ 'development'/'production'/'test' lub coœ podobnego.
      if (empty($this->dbengine)) return 0;
      $config = loader::load("config");
      $dbengineinfo = $config->db;
      if (isset($dbengineinfo[$state]))
      {
         $this->state = $state;
      }
      else
      {
         throw new Exception("W pliku config nie znaleziono
            ['db']['{$state}']");
      }
   }
   function __call($method, $args)
   {
      if (empty($this->dbengine)) return 0;
      if (!method_exists($this, $method))
      return call_user_func_array(array($this->dbengine, $method),$args);
   }
   /* private function __get($property)
   {
      if (property_exists($this->dbengine,$property))
      return $this->dbengine->$property;
   } */
}
