<?php

namespace qoo\core;

/**
*	Standard Exception Handler
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
class ExceptionHandler
{
	/**
	*
	*	Handles the given exception by calling
	*	the handlers method which names are retrieved
	*	with $exception->getHandler();
	*
	*	Please note that you can pass only Exceptions inheriting
	*	from \qoo\core\Exception because handle() needs that interface
	*
	*	@see qoo\core\Exception
	*
	*
	**/
	public function handle(\qoo\core\Exception $exception)
	{
		$handler = $exception->getHandler();
		
		if ($handler !== null && !is_array($handler) )
			trigger_error('Invalid handler returned from  '.get_class($exception).'::getHandler(),
										it should return array (or null)',E_USER_ERROR);
		
		
		if (null !== $handler)
		{
			foreach ($handler as $handle)
			{
				if (!method_exists($this,$handle) )
					trigger_error('Unknown handler  '.get_class($this).'::'.$handle.'()',E_USER_ERROR);
		
				$this->$handle($exception);
			}
		}
		
	}
	
	public function silence(\qoo\core\Exception $exception)
	{
		//Isn't this GREAT!?
		//U must be kidding me..
	}
	
	/**
	*
	*	Outputs useful informations about $exception.
	*
	*	@param \Exception The exception to print
	*
	**/
	public function printReport(\Exception $exception)
	{
		echo "\n \t QOO EXCEPTION \n \n \n";
		if (method_exists($exception,'getType') )
			echo '* Type: '.$exception->getType()."\n";
		echo '* Code: '.$exception->getCode()."\n";
		echo '* File:  '.$exception->getFile()."\n";
		echo '* Line '.$exception->getLine()."\n";
		echo '* Message: '.$exception->getMessage()."\n";
		echo '* Trace: '.$exception->getTraceAsString()."\n";
		
	}
	
	
	/**
	*
	*	Outputs an HTML document containing 
	*	useful informations about $exception.
	*
	*	@param \Exception The exception to print
	*
	**/
	public function printHtmlReport(\Exception $exception)
	{
	
		echo '<html>
			<head>
			<style type="text/css">
			body {font-family:sans-serif;color:black;margin:30px;}
			h1.qoo_exception {font-size:60px;}
			h4.qoo_exception{margin:0px;font-size:30px;}
			div.qoo_exception_red {width:800px;margin-left:20px;margin-bottom:20px;padding:10px;border:1px solid #E01B4C;background-color:#FCD9E2;}
			b.qoo_exception { font-size:20px;}
			ul.qoo_exception {font-size:20px;list-style: square;}
		</style></head><body>
		<h1 class="qoo_exception"> QOO EXCEPTION </h1>
		<ul class="qoo_exception">';
		if (method_exists($exception,'getType') )
			echo '<li><b class="qoo_exception">Type:</b> '.$exception->getType().'</li>';
		echo '<li><b class="qoo_exception">Code:</b> '.$exception->getCode().'</li>';
		echo '<li> <b class="qoo_exception">File:</b>  '.$exception->getFile().'</li>';
		echo '<li><b class="qoo_exception">Line</b> '.$exception->getLine().'</li></ul>';
		echo '<div class="qoo_exception_red"> <h4 class="qoo_exception">Message</h4>'.$exception->getMessage().'</div>';
		echo '<div class="qoo_exception_red"> <h4 class="qoo_exception">Trace</h4>'.$exception->getTraceAsString().'</div>';
		echo '</body></html>';
		

	}
	
	
	
}

?>