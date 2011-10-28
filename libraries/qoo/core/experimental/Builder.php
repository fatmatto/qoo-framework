<?php
namespace qoo\core\experimental;

class BuilderException extends \Exception
{
}

class Builder
{
	
	/**
	*	
	**/
	protected $_Buildables = array();
	
	
	/**
	*
	*	Qui ci metto gli oggetti statici
	**/
	protected static $_SharedBuildables = array();
	
	
	public function __get($name)
	{
		if (isset($this->_Buildables[$name]))
			return $this->_Buildables[$name];
		if (isset($this->_SharedBuildables[$name]))
			return $this->_SharedBuildables[$name];
		
		return;
	}
	
	
	
	/**
	
	*	@param	$item_name
	*	@param	$dependencies
	*	@param	$shared
	*
	*	Usage example
	*	public function register( array ( 	'name' => 'Father',
													'type' = 'FatherWithChildren',
													'dependencies' = array(	'child1' => new Child(),
																					'child2' => new Child()) ,
													'constructor' = '__construct',
													'calls' = array( 'myMethod', array( 'anotherMethod',$another_method_arguments_array ) ),
													'shared' = false) );
	*
	**/
	public function register($config)
	{
		$default = array('shared' => false);
		$config = $config + $default;
		
		if (!is_array($config['dependencies']))
			throw new BuilderException('Dependencies must be an array');
		
		if (true == $config['shared'])
			$this->_SharedBuildables[$config['name']] = $config; 
		else
			$this->_Buildables[$config['name']] = $config;
	}
	
	
	
	/**
	*
	*
	*	@param $item_name
	*	@return bool
	*
	**/
	public function isRegistered($item_name)
	{
		return isset($this->_Buildables[$item_name]) or isset($this->_SharedBuildables[$item_name]);
		
	}
	
	
	
	
	/**
	*
	*
	*
	*	@param		The name of the object you want to build 
	*	@return	The instance of the requested object
	**/
	public function build($item_name)
	{

		$buildable = $this->_Buildables[$item_name];
		
		/***********************************************
		*
		*	Constructor selection
		**********************************************/
		//TODO constructor selection
		
		/***********************************************
		*
		*	Instance creation
		**********************************************/
		if (!class_exists($buildable['type']) )
			throw new BuilderException('TYPE must be a valid class name, '.$buildable['type'].' given');
		$object = new $buildable['type']();
		
		
		
		/***********************************************
		*
		*	Dependencies management
		**********************************************/
		
		
		foreach ($buildable['dependencies'] as $dependency_name => $dependency_type)
		{
			
			//Dependency name is the name of the dependency
			//Dependency type is the type of that dependency
			//So 
				
			if (is_string($dependency_type)) {
				if (!strpos($dependency_type,'.') )
				{
					//Then the object has to be instantiated
					$dependency_name = ucfirst($dependency_name);
					
					$object->$dependency_name = new $dependency_type();
					
				}
				else {
					//Then the object exists already, i have to find it
					$dependency_instance = $this->resolveDependency($dependency_type);
					$dependency_name = strtolower($dependency_name);
					$object->$dependency_name = $dependency_instance;
				}
			}
			
			if (is_object($dependency_type))
			{
				//Then the user want to inject directly this instance
				$dependency_name = strtolower($dependency_name);
				$object->$dependency_name = $dependency_type;
				
			}
			
		}
		
		/***********************************************
		*
		*	Method Calls
		**********************************************/
		//TODO method calls (addMethodCall()->addArgument() 
		
		foreach ($buildable['calls'] as $call)
		{
			if (is_string($call) )
				if (method_exists($object,$call) )
					$object->$call();
			
			if(is_array($call) )
				if (method_exists($object,$call[0]) )
					call_user_func_array(array($object,$call[0]),$call[1]);
		}
		
		
		/***********************************************
		*
		*	Object storing
		**********************************************/
		$buildable['built'] = true;
		$this->$buildable['name'] = $object;
		return $object;
	}
	
	/**
	*
	*
	*	Translates a dependency label into a object 
	*
	*	this.router.myclass	-> dall'istanza locale di router, si prende myclass
	*	myclass -> nuova istanza di myclass
	*	this.myclass ->istanza locale di myclass
	*	
	*	 Le ultime due in realt� dovrebbero essere equivalenti perch� il builder se non ha gi� una istanza
	*	della classe richiesta la creare
	*	
	*/
	private function resolveDependency($dependency)
	{
		$pieces = explode('.',$dependency);
		$target = $this;
		foreach ($pieces as $piece)
		{
			
			if ($piece == 'this')
				$target = $this;
			else
			{
				if (isset($target->$piece))
					$target = $target->$piece;
				elseif (method_exists($target,'get'.ucfirst($piece)))
				{
					$method = 'get'.ucfirst($piece);
					$target = $target->$method();
				}
				else 
					throw new BuilderException("Impossible to resolve the dependency $dependency because there is no way to get $piece. Maybe missing get$piece() method or missing $piece parameter");
				
			}
				
			
		}
		
		return $target;
				
	}
}



?>
