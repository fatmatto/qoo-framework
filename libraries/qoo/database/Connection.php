<?php

namespace qoo\database;

class Connection
{
	public $driver;
	public $host;
	public $user;
	public $password;
	public $dbname;
	public $options;
	
	public function getDsn()
	{
		return strtolower($this->driver).':host='.$this->host.';dbname='.$this->dbname;
	}
}

?>