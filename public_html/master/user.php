require('mysql.php');

abstract class user implements mainDB{
  protected $mysql;
  protected $info;

  
  

  function __construct($id)
    {
      $this->mysql = new mysql($HOST, $USER, $PASSWORD, $DB);
      $this->mysql->connect();
      $this->mysql->select();
      $this->mysql->query("SELECT * FROM users WHERE id = $id");
      $this->info = $this->mysql->fetchQuery();
    }
  
  
  abstract function print_page();
  
  function print_info()
    {
      print<<<START
	<div>
	Name: $info->name<br />
	E-Mail: $info->email<br />
	Address: $info->address<br />
	</div>
      START;
      
    }
      
}



abstract class staff extends user implements mainDB
{
  function __construct($id)
    {
      parent::__construct($id);
    }
  
  abstract function print_page();
  abstract function print_tasks();

}


abstract class boardmember extends staff implements mainDB
{
  function __construct($id)
    {
      parent::__construct($id);
    }
  
  abstract function print_page();
  abstract function print_tasks();
}

class editor extends boardmember implements mainDB
{
  protected $department;
  
  function __construct($id)
    {
      parent::__construct($id);
      $department = $info->department;
    
    }
  
  function print_page()
    {
      print_info();
      print_tasks();
    }
  
  function print_tasks()
    {
      $mysql->query("SELECT * FROM pasteup_articles WHERE department=$department");
      
      print"<div>\n<table>\n<tr><td>Title</td><td>Has Photo?</td><td>Has Art?</td><td></td><td></td></tr>";
      
      while ($row = $mysql->fetchQuery())
	{
	  print<<<START
	    <tr>
	    <td>
	    $row->title
	    </td>
	    <td>
	    START;
	  if ($row->photo==1)
	    print "Yes";
	  else
	    print "No";
	  print "</td>\n<td>\n";
	  if ($row->art==1)
	    print "Yes";
	  else
	    print "No";
	  print<<<START
	    </td>
	    <td>
	    <a href="my_account.php?id=$row->id;action=modify">Modify</a>
	    </td>
	    <td>
	    <a href="my_account.php?id=$row->id;action=assign">Assign</a>
	    </td>
	    <td>
	    <a href="my_account.php?id=$row->id;action=delete">Delete</a>
	    </td>
	    </tr>
	    START;
	 
	}
       print "</table>";
    }


}