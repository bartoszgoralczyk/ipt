<?php
class benchmark
{
   private $times = array();
   private $keys = array();
   public function setMarker($key=null)
   {
      $this->keys[] = $key;
      $this->times[] = microtime(true);
   }
   public function initiate()
   {
      $this->keys= array();
      $this->times= array();
   }
   public function printReport()
   {
      $cnt = count($this->times);
      $result = "";
      for ($i=1; $i<$cnt; $i++)
      {
         $key1 = $this->keys[$i-1];
         $key2 = $this->keys[$i];
         $seconds = $this->times[$i]-$this->times[$i-1];
         $result .= "Przejscie od '{$key1}' do '{$key2}' : {$seconds}
            zajel sekund.</br>";
      }
      $total = $this->times[$i-1]-$this->times[0];
      $result .= "Calkowity czas wyniosl : {$total} sekund.</br>";
      echo $result;
   }
}
