<?php

namespace qoo\controller;

/**
*
*
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class ViewException Extends \qoo\core\Exception {}

/**
*
*	Standard view.
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class View extends \qoo\core\Object
{
	/**
	 * 
	 * View name (ROOT/application/views/name.php)
	 * @var string
	 */
	private $_ViewName;
	
	/**
	*
	* @var string The path to the views directory
	*/
	private $_Directory = null;
	
	
	/**
	*
	*	Standard constructor
	*
	*
	**/
	public function __construct()
	{
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param the view name
	 * @throws ViewException
	 * 
	 * 
	 */
	public function setView($view_name)
	{	
		$this->_ViewName = $view_name;
	}
	
	/**
	*
	*
	*	The default directory is APP_ROOT/view/
	*
	*	@param $directory The directory in which the view file is placed (ending with / or \)
	*
	**/
	public function setDirectory($directory)
	{
		if (!is_dir($directory) )
			throw new ViewException('The given directory '.$directory.' does not exists');
		
		
		$this->_Directory = $directory;
	}
	
	public function getDirectory()
	{
		return $this->_Directory;
	}
	
	
	/**
	 * 
	 * Assign the valure $value to the tag $tag inside the template file
	 * @param unknown_type $value
	 * @param unknown_type $tag
	 * @throws ViewException
	 */
	public function assign($tag,$value)
	{
		if ($tag == '_ViewName')
			throw new ViewException('_ViewName is a reserved name, please use another one');
		$this->$tag = $value;
		
	}
	
	
	/**
	*
	*	This is the method that actually includes the view file and returns output
	*
	**/
	private function _prepareRendering()
	{
		if (!$this->_ViewName)
			throw new ViewException("You must load a view file before calling render()");
		
		if (null === $this->_Directory)
			$this->setDirectory(APP_ROOT.'view/');
		
		if (!file_exists($this->_Directory.$this->_ViewName.'.php') )
			throw new ViewException('The view file '.$this->_Directory.$this->_ViewName.'.php does not exist');
		
		extract(array('view' => $this));
		//Output
			
		require($this->_Directory.$this->_ViewName.'.php');

	}
	
	/**
	*
	*	Return a string containing the output of the rendered view.
	*
	*	It makes use of php output buffering features.
	*	@return String The output string
	*/
	public function render()
	{
		ob_start();
		$this->_prepareRendering();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	
	
}
