<?php

	
/**
*	Base class that implements dependency injection via set/get methods
*
*	Example:

		$c = new MethodInjectable();
		$c->set( array( 	'request' => new Request(),
							'response' => new Response() ) );
	
		var_dump($c->get('request'));
		var_dump($c->get('response'));
*
*	@livense BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
abstract class MethodInjectable extends qoo/core/Object
{
	/**
	*
	*
	*
	*
	**/
	protected $_Data = array();
	
	/**
	*
	*
	*
	*
	**/
	public function set($dependency, $value=null)
	{
		if (is_array($dependency) && $value === null)
		{
			foreach ($dependency as $name => $value)
			{
				if (is_string($name))
					$this->_Data[$name] =new $value() ;
				else
					$this->_Data[$name] =$object;
			}
		}
		else
		{
			if (is_string($value))
				$this->_Data[$dependency] =new $value();			
			else
				$this->_Data[$dependency] =$value ;
		}
	}
	
	/**
	*
	*
	*	Returns the requested item
	*	
	*
	**/
	public function get($item_name)
	{
		
		if ( is_callable( $this->_Data[$item_name] ) ) 
			return $this->_Data[$item_name]($this);
			
		return $this->_Data[$item_name];
	}
	
	
	
}


?>
