<?php

namespace qoo\core;
/**
*
*	Abstract class with which you can easily implement constructor dependency injection
*
*	It's basically the same as ConstructorInjectable, but if you don't
*	pass some required object to the constructor, then the object
*	tries to create instances of those missing objects.
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*
*	@see ConstructorInjectable
**/
abstract class ConstructorInjectableAuto extends \qoo\core\Object
{
	/**
	*
	*	A generic constructor that implements <b>dependency injection</b>.
	*	Usage example:
	*	
	*	class myClassAuto extends ConstructorInjectableAuto
	*	{
	*		protected $_Dependencies = array( 'class1' => new Class1(),
	*													'class2' => $object );
	*
	*		public function doSomething($with_this) {
	*		//
	*		}
	*	}
	*
	*	As you can see from the previous example, the constructor takes an array as parameter
	*	in which each key is the name of the property that will be injected into the object instance
	*	and each value is the dependency.
	*
	*	You can also pass a classname as a dependency value, the constructor will look for a class
	*	named classname and will instantiate a new classname(). For example:
	*
	*	$c = new myCar( array( 'engine' => 'my/namespace/Engine',
	*										'wheels' => $wheels_pack,
	*										'driver' => new Driver('John'),
	*										'brand' => "BMW" ) );
	*	engine ->The injector will look for the my/namespace/Engine and instantiate it and store it as the engine property
	*	wheels -> The constructor finds an object and will directly store it
	*	driver -> Same as wheels
	*	brand	-> In this case the constructor will not find any class named BMW and will instantiate it
	**/
	public function __construct($dependencies = array())
	{
		
		$dependencies = $dependencies + $this->_Dependencies;
		
		
		foreach ($dependencies as $dependency_name => $dependency_value)
		{

			if (is_string($dependency_value) && class_exists($dependency_value))
				{
						$this->$dependency_name = new $dependency_value();
				}
			else
				{
				$this->$dependency_name = $dependency_value;
				}
		}
	}
	
	
	
}



