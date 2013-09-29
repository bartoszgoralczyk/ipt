<?php

class unittest
{
   private static $results = array();
   private static $testmode = false;
   public static function setUp()
   {
      $config = loader::load("config");
      if ($config->unit_test_enabled){
         self::$results = array();
         self::$testmode = true;
      }
   }
   public static function tearDown()
   {
      if (self::$testmode)
      {
         self::printTestResult();
         self::$results = array();
         self::$testmode = false;
         die();
      }
   }
   public static function printTestResult()
   {
      foreach (self::$results as $result)
      {
         echo $result."<hr/>";
      }
   }
   public static function assertTrue($object)
   {
      if (!self::$testmode) return 0;
      if (true==$object) $result = "zaliczony";
      self::saveResult(true, $object, $result);
   }
   public static function assertEqual($object, $constant)
   {
      if (!self::$testmode) return 0;
      if ($object==$constant)
      {
         $result = 1;
      }
      self::saveResult($constant, $object, $result);
   }
   private static function getTrace()
   {
      $result = debug_backtrace();
      $cnt = count($result);
      $callerfile = $result[2]['file'];
      $callermethod = $result[3]['function'];
      $callerline = $result[2]['line'];
      return array($callermethod, $callerline, $callerfile);
   }
   private static function saveResult($expected, $actual,
                                              $result=false)
   {
      if (empty($actual)) $actual = "null/false";
      if ("failed"==$result || empty($result))
      $result = "<font color='red'><strong>niezaliczony</strong></font>";
      else
      $result = "<font color='green'><strong>zaliczony</strong></font>";
      $trace = self::getTrace();
      $finalresult = "Test {$result} in metodzie:
         <strong>{$trace[0]}</strong>. Wiersz:
         <strong>{$trace[1]}</strong>. Plik:
         <strong>{$trace[2]}</strong>. <br/> Wartoœæ oczekiwana:
         <strong>{$expected}</strong>, Wartoœæ bie¿¹ca:
         <strong>{$actual}</strong>. ";
      self::$results[] = $finalresult;
   }
   public static function assertArrayHasKey($key, array $array,
                                                     $message = '')
   {
      if (!self::$testmode) return 0;
      if (array_key_exists($key, $array))
      {
         $result = 1;
         self::saveResult("Tablica posiada klucz o nazwie '{$key}'",
            "Tablica posiada klucz o nazwie '{$key}'", $result);
         return ;
      }
      self::saveResult("Tablica posiada klucz o nazwie '{$key}'",
         "Tablica nie posiada klucza o nazwie '{$key}'", $result);
   }
   public static function assertArrayNotHasKey($key, array $array,
                                               $message = '')
   {
      if (!self::$testmode) return 0;
      if (!array_key_exists($key, $array))
      {
         $result = 1;
         self::saveResult("Tablica nie posiada klucza o nazwie '{$key}'",
            "Tablica nie posiada klucza o nazwie '{$key}'", $result);
         return ;
      }
      self::saveResult("Tablica nie posiada klucza o nazwie '{$key}'",
         "Tablica posiada klucz o nazwie '{$key}'", $result);
   }
   public static function assertContains($needle, $haystack,
                           $message = '')
   {
      if (!self::$testmode) return 0;
      if (in_array($needle,$haystack))
      {
         $result = 1;
         self::saveResult("Tablica posiada element o nazwie '{$needle}'",
            "Tablica posiada element o nazwie '{$needle}'", $result);
         return ;
      }
      self::saveResult("Tablica posiada element o nazwie '{$needle}'",
         " Tablica nie posiada elementu o nazwie '{$needle}'", $result);
   }
}
