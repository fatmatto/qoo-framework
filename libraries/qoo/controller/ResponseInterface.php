<?php

namespace qoo\controller;

/**
*
*	Response Interface.
*
*	@license BSD
*	@author Mattia Alfieri <mattia.alfieri@ymail.com>
**/
interface ResponseInterface
{
	/**
	*
	*	Sends the Response to the client
	*
	**/
	public function send();
}

?>
