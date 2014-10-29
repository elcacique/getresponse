<?php

class DB_MySQL
{
	private $hostname = HOSTNAME;
	private $username = USERNAME;
	private $password = PASSWORD;
	private $database = DATABASE;
	private $query;

	public function __construct()
	{
		@ mysql_connect($this->hostname, $this->username, $this->password) OR die(mysql_error());
		@ mysql_select_db($this->database) OR die(mysql_error());
		
		$this->Execute("SET NAMES 'utf8'");
		$this->Execute("SET CHARACTER SET 'utf8'");
		
		return true;
	}
	
	public function Execute($query)
	{
		$this->query = $query;
		$result = mysql_query($this->query);
		
		if(!$result) return false;
		
		return $result;
	}
}

?>