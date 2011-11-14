<?php

namespace qoo\storage;

use qoo\core;


/*
*	wraps php's session handling
*
*
*/
class Session {


	/*
	*	Same as session_start()
	*/
	public function start() {
		session_start();
	}
	
	
	public function set($name,$value) {
		if (!is_string($name))
			throw new qoo/Exception("First argument of qoo/storage/Session::set() must be string");
		$_SESSION[$name] = $value;
	}
	
	public function get($name) {
		return $_SESSION[$name];
	}
	
	public function destroy()
	{
		session_destroy();
	}
	
	public function has($name) {
		return isset($_SESSION[$name]);
	}
}

?>
