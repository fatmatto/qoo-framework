<?php

namespace qoo\database;

class Database extends \PDO
{
	/**
	*
	*
	*	@param \qoo\database\Connection $connection
	**/
	public function __construct($connection)
	{
		parent::__construct($connection->getDsn(),$connection->user,$connection->password,$connection->options);
	}
	

}

?>