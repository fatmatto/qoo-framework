<?php
namespace qoo\core;

/**
*
*	Standard base class that implements constructor injection.
*	Classes listed in _Dependencies will be required by the constructor which
*	will throw an exception if can't find any of them.
*
*	class myClass extends /qoo/core/ConstructorInjectable
*	{
*		$_Dependencies = array( 'logger' => 'qoo/utils/logger');
*	}
*	
*	if You try to instantiate this class like this:
*	$c = new myClass();
*	
*	You will get an exception saying that the dependency logger is missing
*	
*	$c = new myClass( array( 'logger' => new XmlLogger()) );
*	
*	Will work fine
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*	@package	qoo
*
*
**/
class ConstructorInjectable extends \qoo\core\Object
{
	/**
	*
	*	List of classes required by the constructor
	*
	**/
	protected $_Dependencies = array();
	
	
	public function __construct( $dependencies = array() )
	{
		
		foreach ( $this->_Dependencies as $name => $class)
		{
			if (!isset($dependencies[$name]) OR $class !== get_class($dependencies[$name]) )
				throw new \qoo\core\Exception('Missing required dependency '.$name.' of type '.$class.' for '.get_class($this).'');
			
			
		}
		
		foreach ($dependencies as $name => $class)
		{
			$this->$name = $class;
		}
	}
	
}

?>
