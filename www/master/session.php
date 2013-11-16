class session implements /*fill this*/
{

protected $id;
protected $level;

function __construct()
{
	if (isset($_SESSION['id'])&&isset($_SESSION['level']))
	{
	$this->id=$_SESSION['id'];
	$this->level=$_SESSION['level'];
	}
	else
	{
	print "Cannot Create Session";
	}
}



static function check_valid($email, $password)
{
	$mysql = new mysql();
	$mysql->query("SELECT id, level FROM users WHERE email=$email AND password = $password");
	if ($mysql->affectedRows()==1)
	{	
	list($id,$level) = $mysql->fetchRow
	session_register();
	$_SESSION['id']=$id;
	$_SESSION['level']=$level;
	return 1;
	}
	else
	{
	return 0;
	}
}

function get_id()
{
return $id;
}


function get_level()
{
return $level;
}

}