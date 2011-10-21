<?php

namespace qoo\core;

/**
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*	@package	qoo
**/
class ContainerException extends \Exception
{}

/**
*
*	Standard Container class
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*	@package qoo
**/
class Container extends \qoo\core\Object
{
	protected $_Data = array();
	protected static $_SharedData = array();
	
	
	/**
	*
	*	@param $item_name String The name of the item you want to check the existance
	**/
	public function has($item_name)
	{
		if (array_key_exists($item_name,$this->_Data) )
			return true;
		
		
			return false;
	}
	
	/**
	*
	*	@param $item_name string The name of the object you want to retrieve
	*	@return Mixed
	**/
	public function get($item_name)
	{
		if (!$this->has($item_name) )
			throw new ContainerException("ContainerException: The requested component $item_name does not exists");
		
		if ( is_callable( $this->_Data[$item_name] ) ) {
			return $this->_Data[$item_name]($this);	
			}
		
			return $this->_Data[$item_name];
	}
	
	
	
	/**
	*
	*
	*	@param $item_name The Name of the object you want to store
	*	@param $item	The object ou want to store
	*
	**/
	public function set($item_name,$item)
	{
		$this->_Data[$item_name] = $item;
	}
	
	
	
	/**
	*	Static version of set
	*
	*	@param $item_name The Name of the object you want to store
	*	@param $item	The object ou want to store
	*
	**/
	public function setShared($item_name,$item)
	{
		self::$_SharedData[$item_name] = $item;
	}
	
	
	
	public function isShared($item_name)
	{
		return isset(self::$_SharedData[$item_name]);
	}
	
	/**
	*	Static version of get
	*
	*	@param $item_name string The name of the object you want to retrieve
	*	@return Mixed
	**/
	public function getShared($item_name)
	{
		if ($this->isShared($item_name) )
			return self::$_SharedData[$item_name];
		else
			return;
	}
	
	
}


?>