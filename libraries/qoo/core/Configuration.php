<?php
namespace qoo\core;

class ConfigurationException extends Exception {}


/**
*	Simple class that encapsulates parse_ini_file() into an object structure
*
*	@author Mattia Alfieri
*	@package qoo
**/
class Configuration
{

	private $_ConfigObject;
	
	public function __construct()
	{}
	
	
	
	/**
	*
	*	@param $configuration_file_path string The path to the configuration file. (Must be an .ini file)
	*	@param $with_sections bool Set to true if you want to use sections in your .ini file
	*	
	**/
	public static function load($configuration_file_path,$with_sections = false)
	{
		if (!file_exists($configuration_file_path) )
			throw new ConfigurationException("The configuration file $configuration_file_path does not exists");
		else
			self::$_ConfigObject = (Object) parse_ini_file($configuration_file_path,$with_sections);
	}
}

?>
