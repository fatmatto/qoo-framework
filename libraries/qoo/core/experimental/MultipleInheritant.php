<?php
namespace qoo\core\experimental;


/**
*
*	Simple abstract class that allow your objects (not classes!)
*	to virtually "inherit" methods and properties from other classes.
*
*	It's virtual because it adds nothing more to your class definition.
*	It just add methods runtime.
*
**/
abstract class MultipleInheritant
{
	/**
	*
	*	@var mixed Array of superclasses
	*
	**/
	protected $_Superclasses = array();
	
	public function inherit($class)
	{
		if (is_object($class) )
			array_push($this->_Superclasses,$class);
		elseif (is_string($class) && class_exists($class))
			array_push($this->_Superclasses,new $class());
		elseif(is_string($class) && !class_exists($class))
			throw new \Exception("$class is not a classname");
		else
			throw new \Exception("You can inherit only classnames or instances");
		
	}
	
	//Restituisce il punt all'oggetto che contiene il metodo desiderato
	private function LookForClassWithMethod($class,$method)
	{
			if (method_exists($class,$method) )
					return $class;
				
			
			foreach( $class->getInheritedInstances() as $inherited)
			{
				if (method_exists($inherited,$method) )
					return $inherited;
				
				//WOOP WOOP GOING TO FIX THIS ASAP!
				if (is_subclass_of($inherited,'/qoo/core/MultipleInheritant') )
					return $this->LookForClassWithMethod($inherited,$method);
			}
			
			return null;
			
	}
	
	public function getInheritedInstances()
	{
		return $this->_Superclasses;
	}
	
	
	public function __call($method,$args = array())
	{
		$super = $this->LookForClassWithMethod($this,$method);
		
		
	
		if (null === $super)
			throw new \Exception('Call to undefined method <b>'.$method.'</b> in class <b>'.get_class($this).'</b>' );
		
		switch (count($args) )
		{
			case 0:
				$super->$method();
			break;
			case 1:
				$super->$method($args[0]);
			break;
			case 2:
				$super->$method($args[0],$args[1]);
			break;
			case 3:
				$super->$method($args[0],$args[1],$args[2]);
			break;
			case 4:
				$super->$method($args[0],$args[1],$args[2],$args[3]);
			break;
			case 5:
				$super->$method($args[0],$args[1],$args[2],$args[3],$args[4]);
			break;
			case 6:
				$super->$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]);
			break;
			case 7:
				$super->$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]);
			break;
			case 8:
				$super->$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7]);
			break;
			default:
				throw new \Exception('The inherited method '.$method.' in class '.get_class($this).' has too many arguments to be handled by qoo\core\MultipleInheritant' );
			break;
		}
	}
	
	public function __get($property)
	{
		foreach($this->_Superclasses as $super_type => $super_instance)
		{
				if (property_exists($super_instance,$property) )
				return $super_instance->$property;
		}
		
		throw new \Exception('Call to undefined property named '.$property.' from '.get_class($this));
	}
	
}
?>
