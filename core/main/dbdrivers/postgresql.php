<?php
class pgsqldriver extends abstractdbdriver
{
   public function __construct($dbinfo)
   {
      if (!empty($dbinfo['dbname']))
      {
         if ($dbinfo['persistent'])
         $this->connection = pg_pconnect("host={$dbinfo['dbname']}
         port=5432 dbname={$dbinfo['dbname']} user={$dbinfo['$dbuser']}
         password={$dbinfo['dbpwd']}");
         else
         $this->connection = pg_connect("host={$dbinfo['dbname']}
         port=5432 dbname={$dbinfo['dbname']} user={$dbinfo['$dbuser']}
         password={$dbinfo['dbpwd']}");
      }
      else
         throw new Exception("Aby nawi¹zaæ po³¹czenie z baz¹ danych PostgreSQL, trzeba
            podaæ nazwê u¿ytkownika, has³o, serwer oraz nazwê u¿ywanej bazy danych ");
   }
   public function execute($sql)
   {
      $sql = $this->prepQuery($sql);
      $parts = split(" ",trim($sql));
      $type = strtolower($parts[0]);
      $hash = md5($sql);
      $this->lasthash = $hash;
      if ("select"==$type)
      {
         if (isset($this->results[$hash]))
         {
            if (is_resource($this->results[$hash]))
            return $this->results[$hash];
         }
      }
      else if("update"==$type || "delete"==$type)
      {
         $this->results = array(); // Usuniêcie zawartoœci bufora wyników.
      }
      $this->results[$hash] = pg_query($this->connection,$sql);
   }
   public function count()
   {
      // print_r($this);
      $lastresult = $this->results[$this->lasthash];
      // print_r($this->results);
      $count = pg_num_rows($lastresult);
      if (!$count) $count = 0;
      return $count;
   }
   private function prepQuery($sql)
   {
      // Polecenie "DELETE FROM TABLE" zwraca 0 rekordów.
      // Ten kod modyfikuje wymienione zapytanie w taki sposób,
      // aby zwraca³o ono liczbê rekordów, które zosta³y zmodyfikowane przez zapytanie.
      if (preg_match('/^\s*DELETE\s+FROM\s+(\S+)\s*$/i', $sql))
      {
         $sql = preg_replace("/^\s*DELETE\s+FROM\s+(\S+)\s*$/",
            "DELETE FROM \\1 WHERE 1=1", $sql);
      }
      return $sql;
   }
   public function escape($sql)
   {
      if (function_exists('pg_escape_string'))
      {
         return pg_escape_string( $sql);
      }
      else
      {
         return addslashes($sql);
      }
   }
   public function affectedRows()
   {
      return @pg_affected_rows($this->connection);
   }
   public function insertId($table=null, $column=null)
   {
      $_temp = $this->lasthash;
      $lastresult = $this->results[$this->lasthash];
      $this->execute("SELECT version() AS ver");
      $row = $this->getRow();
      $v = $row['server'];
      $table = func_num_args() > 0 ? func_get_arg(0) : null;
      $column = func_num_args() > 1 ? func_get_arg(1) : null;
      if ($table == null && $v >= '8.1')
      {
         $sql='SELECT LASTVAL() as ins_id';
      }
      elseif ($table != null && $column != null && $v >= '8.0')
      {
         $sql = sprintf("SELECT pg_get_serial_sequence('%s','%s') as
            seq", $table, $column);
         $this->execte($sql);
         $row = $this->getRow();
         $sql = sprintf("SELECT CURRVAL('%s') as ins_id", $row['seq']);
      }
      elseif ($table != null)
      {
         // Przekazanie seq_name parametrze tabeli.
         $sql = sprintf("SELECT CURRVAL('%s') as ins_id", $table);
      }
      else
      {
         return pg_last_oid($lastresult);
      }
      $this->execute($sql);
      $row = $this->getRow();
      $this->lasthash = $_temp;
      return $row['ins_id'];
   }
   public function transBegin()
   {
      return @pg_exec($this->connection, "BEGIN");
      return TRUE;
   }
   public function transCommit()
   {
      return @pg_exec($this->connection, "COMMIT");
      return TRUE;
   }
   public function transRollback()
   {
      return @pg_exec($this->connection, "ROLLBACK");
      return TRUE;
   }
   public function getRow($fetchmode = FETCH_ASSOC)
   {
      $lastresult = $this->results[$this->lasthash];
      if (FETCH_ASSOC == $fetchmode)
      $row = pg_fetch_assoc($lastresult);
      elseif (FETCH_ROW == $fetchmode)
      $row = pg_fetch_row($lastresult);
      elseif (FETCH_OBJECT == $fetchmode)
      $row = pg_fetch_object($lastresult);
      else
      $row = pg_fetch_array($lastresult,PGSQL_BOTH);
      return $row;
   }
   public function getRowAt($offset=null,$fetchmode = FETCH_ASSOC)
   {
      $lastresult = $this->results[$this->lasthash];
      if (!empty($offset))
      {
         pg_result_seek($lastresult, $offset);
      }
      return $this->getRow($fetchmode);
   }
   public function rewind()
   {
      $lastresult = $this->results[$this->lasthash];
      pg_result_seek($lastresult, 0);
   }
   public function getRows($start, $count, $fetchmode = FETCH_ASSOC)
   {
      $lastresult = $this->results[$this->lasthash];
      $rows = array();
      for ($i=$start; $i<=($start+$count); $i++)
      {
         $rows[] = $this->getRowAt($i,$fetchmode);
      }
      return $rows;
   }
   function __destruct()
   {
      foreach ($this->results as $result)
      {
         @pg_free_result($result);
      }
   }
}
?>
