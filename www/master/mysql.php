class mysql{ 
  protected $linkid; 
  protected $host; 
  protected $user; 
  protected $pswd; 
  protected $db; 
  protected $result; 
  protected $querycount; 
  /*initialize crucial variables*/ 
  function __construct($host, $user, $pswd, $db) 
    { 
      $this->host = $host; 
      $this->user = $user; 
      $this->pswd = $pswd; 
      $this->db = $db; 
    } 
  
  
  /*connect to server*/ 
  function connect() 
    { 
      try {
	$this->linkid = @mysql_connect($this->host, $this->user, $this->pswd); 
	if (! $this->linkid) 
	  throw new Exception("Could not connect to server"); 
      } 
      catch (Exception $e)
	{ 
	  die($e->getMessage()); 
	} 
    } 
  /*Select MYSQL database*/
  function select()
    {
      try {
	$this->result = @mysql_query($query,$this->linkid);
	if (!$this->result)
	  throw new Exception("The Database Query Failed");
	
      }
      catch (Exception $e)
	{
	  die($e->getMessage());
	}
    }
  
  
  /*Execute Database Query*/
  function query($query)
    {
      try {
	$this->result = @mysql_query($query,$this->linkid);
	if (! $this->result)
	  throw new Exception("The database query failed");
      }
      catch (Exception $e)
	{
	  echo($e->getMessage());
	}
      $this->querycount++;
      return $this->result;
    }

  /*Determine number of rows affected by query*/
  
  function affectedRows()
    {
      $count = @mysql_affected_rows($this->linkid);
      return $count;
    }
  
  /*Determine total rows returned by query */
  function numRows() 
    {
      $count = @mysql_num_rows($this->result);
      return $count;
    }
  
  /*Return query result in object form */
  function fetchQuery()
    {
      $row = @mysql_fetch_object($this->result);
      return $row;
    }
  
  /*Return query result row as an indexed array */
  function fetchRow()
    {
      $row = @mysql_fetch_row($this->result);
      return $row;
    }

  /*return query result row as an associative array*/
  function fetchArray()
    {
      $row = @mysql_fetch_row($this->result);
      return $row;
    }


  /*interesting extension shows total execution history in terms 
    of commands executed */
  
  function numQueries() 
    {
      return $this->queryCount();
    }
}
      
