<?php

namespace qoo\core;

/**
*	Standard Exception class with some benefits.
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class Exception extends \Exception
{
	protected $_Params = array();
	protected $_Handlers = array();
	
	/*
	*
	*	@return array Returns an array containing every piece of information about the exception.
	*
	**/
	public function getInfo()
	{
		return array(	'message' => $this->getMessage(),
						'file' => $this->getFile(),
						'line' => $this->getLine(),	
						'code' => $this->getCode(),
						'trace' => $this->getTraceAsString(),
						'type' => $this->getType() );
	}
	
	/**
	*
	*
	*	@return string The type (class name) of the exception.
	*
	**/
	public function getType()
	{
		return get_class($this);
	}
	
	public function getParam($name)
	{
		if (isset($this->_Params[$name]))
			return $this->_Params[$name];
		
		return null;
	}
	
	public function setParam($name,$value)
	{
		$this->_Params[$name] = $value;
	}
	
	/**
	*
	*	Sets a list of handlers that will be used with this exception once cought.
	*	You can also pass a string containing the name of one handler if you want:
	*	$e->setHandler( 'logExcepion' );
	*	Is the same as:
	*	$e->setHandler( array('logExcepion') ); //Best pracc
	*
	*	But if you need more that one handler to work on this exception, you need an array:
	*	$e->setHandler( array('logExcepion','printReport') );
	*	
	*	@param Array $handlers The array containing which handlers will handle this request.
	*
	**/
	public function setHandlers($handlers)
	{
		if (!is_array($handlers) && !is_string($handlers) && null !== $handlers)
			trigger_error('Invalid argument for method \qoo\core\Exception::setHandler($handlers) : $handler must be string or string array',E_USER_ERROR);
		
		if (is_string($handlers))
			$handler = array($handlers);
		
		$this->_Handler = $handler;
	}
	
	/**
	*
	*	
	*	@return array
	*
	**/
	public function getHandlers()
	{
		return $this->_Handlers;
	}
	
}

?>
