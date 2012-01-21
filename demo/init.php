<?php
//qoo initialization

/*
	*
	*	Change this directory to whatever you placed the green directory after you downloaded it
	*
*/
define("QOO_ROOT",'../'); //Edited by ntrp (works everywhere fatto pirla xD)
/*
	*
	*	Change this directory to whatever you want to place your application directory.
	*	Please, note that under the application directory you should have 3 subdirectory: controllers, models and views
	*
*/
define("APP_ROOT",QOO_ROOT.'demo/');

/*
*
*	This is a useful check
*/
define ("QOO_VERSION" , "Beta20111026");



//We make things easyer ;D
function __autoload($class_name)
{
		//
		if (!class_exists($class_name) )
		{
			$class_name = str_replace("\\","/",$class_name);
			
			if ( file_exists(QOO_ROOT.'libraries/'.$class_name.'.php') )
				require_once(QOO_ROOT.'libraries/'.$class_name.'.php');
			else {
				echo "<b>QOO::ERROR</b> Class $class_name could not be loaded because the required file <b>".QOO_ROOT.'libraries/'.$class_name.'.php'."</b> does not exist.<br>";
				die();
				}
		}
}





?>
