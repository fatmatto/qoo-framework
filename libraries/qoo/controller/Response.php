<?php
namespace qoo\controller;

class ResponseException extends \qoo\core\Exception
{}

/**
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
*	@see ResponseInterface
**/
class Response extends \qoo\core\Object implements \qoo\controller\ResponseInterface
{
	//TODO implement output buffering
	
	
	protected $_Content = '';
	
	protected $_Headers = array();
	
	
	public function __construct()
	{
		ob_start();
	}
	
	
	
	/**
	*
	*	Sends the output to the client
	**/
	public function send() {
		
		foreach ($this->_Headers as $header_name => $header)
		{
			//TODO make this more readable..
			header($header[0],$header[1]);
		}
		echo $this->_Content;
		ob_end_flush();
	}
	
	public function clear()
	{
		$this->_Content = '';
		ob_get_flush();
	}
	
	/**
	*
	*	Wraps header() php function
	**/
	public function setHeader($header_name,$header_value,$replace=true)
	{
		$header = array($header_value,$replace);
		$this->_Headers[$header_name] = $header;
	}
	
	
	
	/**
	*
	*
	*
	**/
	public function getHeader($header_name)
	{
		return $this->_Headers[$header_name];
	}
	
	/**
	*
	*
	*
	**/
	public function append($content)
	{
		if (!is_string($content) && null !== $content)
			throw new ResponseException('Attempt to append non-string object to response body');
		
		$this->_Content .= $content;
	}
	
	/**
	*
	*
	*	@param $content_name The name of the content setted into the Response object that you want to retrieve
	**/
	public function getContent()
	{
		return $this->_Content;
	}
	
	/**
	*
	*
	* 	
	**/
	public function setContent($content)
	{
		$this->_Content = $content;
	}
	
	/**
	*
	*
	*
	**/
	public function setCookie()
	{}
	
	
	/**
	*
	*
	*
	**/
	public function setContentType()
	{}
	
	/**
	*
	*
	*
	**/
	public function setStatus()
	{}
	
	/**
	*
	*
	*
	**/
	public function setRedirect()
	{}
	
	
	
	
}