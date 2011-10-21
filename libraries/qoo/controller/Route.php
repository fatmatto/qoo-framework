<?php

namespace qoo\controller;

class RouteException extends \qoo\core\Exception
{}

/**
*
*	$router->createRoute('route_name')
				->map('/some/uri/%pattern%/')
				->setParam('controller','DefaultController')
				->setParam('action','index')
				->setParam('var',15)
				->bindParam('var','numeric')
*
*
**/
class Route extends \qoo\core\Object implements \qoo\controller\RouteInterface
{
	protected $_Pattern;
	protected $_ParameterBindings;
	public function __construct($pattern = '', $parameters= array(), $bindings= array())
	{
		$this->_Pattern = $pattern;
		$this->setParams($parameters);
		$this->_ParameterBindings = $bindings;
	}
	
	public function map($pattern)
	{
		
		if (!is_string($pattern))
			throw new RouteException('Pattern must be string!');
		
		if('/' !== substr($pattern,-1) )
			$pattern .= '/';
		
		$this->_Pattern = $pattern;
		
		return $this;
	}
	
	public function setParam($name,$value)
	{
		parent::setParam($name,$value);
		return $this;
	}
	
	public function bindParam($name,$type)
	{
		$this->_ParameterBindings[$name] = $type;
		return $this;
	}
	
	/**
	*
	*	@return bool True if the uri matches the route pattern
	*/
	public function match($uri)
	{
		$route_parameters = array();
		if('/' !== substr($uri,-1) )
			$uri .= '/';
		
		//Fast matching 
		if($uri === $this->_Pattern)
			return true;
		
		//Array of pattern items
		$chunks = explode('/',$this->_Pattern);
		$k = 0;
		foreach($chunks as $chunk)
		{
			
			if (false !== strpos($chunk,'{')) //if the chunk is a parameter
			{
				//$name is the name of the parameter found
				$name = substr($chunk,1,-1);
				array_push($route_parameters,$name);
				
				//We loop inside the bindings array in order to find which filter we should apply
				
				if (isset($this->_ParameterBindings[$name]) )
					switch ($this->_ParameterBindings[$name])
					{
						case 'numeric':
							$chunks[$k] = '(\d+)';
						break;
						case 'alpha':
							$chunks[$k] = '([A-Za-z]+)';
						break;
						case 'alpha-numeric':
							$chunks[$k] = '([A-Za-z0-9]+)';
						break;
						case 'any':
							$chunks[$k] = '([A-Za-z0-9-_#]+)';
						break;
						default :
							$chunks[$k] = $this->_ParameterBindings[$name];
						break;
						
					}
					
					
				else
					$chunks[$k] = '([A-Za-z0-9-_#]+)';
				
				
					
			}
			$k++;
		}
		//We build the regex string
		$regex = implode('/',$chunks);
		$regex = str_replace("/","\/",$regex);
		
		if (preg_match_all("/^".$regex."$/",$uri,$matches) )
		{
			$max = count($matches);
			for ($counter = 1; $counter < $max; $counter++)
			{
				//We set the pattern parameter into the route
				$this->setParam($route_parameters[$counter-1] , $matches[$counter][0] );
			}
			return true;
		}
	}
	
	
}

?>