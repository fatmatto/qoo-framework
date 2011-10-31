<?php

//Command line app generator v0.1

$version = 'v0.1';

$option = $argv[1];
$application_name = $argv[2];
$application_directory = $argv[3];

function printHelp()
{
	echo "USAGE:\n \t php app_generator.php create <APPLICATION_NAME> <APPLICATION_DIRECTORY>\n";
}





switch ($option)
{
	case "create":
		
		//Directory Tree creation
			mkdir($application_directory."/".$application_name);
	$application_directory =  $application_directory."/".$application_name;
	mkdir($application_directory."/controller");
	mkdir($application_directory."/view");
	mkdir($application_directory."/model");
	mkdir($application_directory."/resources");
	mkdir($application_directory."/config");
		
		//Init File data gathering
		print 'Enter the directory in which you installed qoo framework (e.g. C:\xampp\htdocs\qoo_framework) :'."\n";
		$handle = fopen ("php://stdin","r");
		$qoo_directory = trim(fgets($handle));
		if (!file_exists($qoo_directory))
			while (!file_exists($qoo_directory) )
			{
				print "The directory is not valid, insert a valid one:\n";
				$qoo_directory = trim(fgets($handle));
			}
		
		$init_content = "<?php
//qoo initialization

//Generated with qoo Application Generator script 'v $version'

/*
	*
	*	Change this directory to whatever you placed the qoo directory after you downloaded it
	*
*/
define(\"QOO_ROOT\",'$qoo_directory');
/*
	*
	*	Change this directory to whatever you want to place your application directory.
	*	Please, note that under the application directory you should have 3 subdirectory: controllers, models and views
	*
*/
define(\"APP_ROOT\",'$application_directory');


/*
*
*	This is a useful check
*/
define (\"QOO_VERSION\" , \"Beta20111019\");


/*	We make things easyer with autoload ;D
*	Beware that this only affects classes inside the libraries directory
* 	Models Views and Controllers are loaded by their classes
* 	Other 3d party libs have to be loaded with loader or you have to write your code.
* 	See the Loader class documentation to learn how to load your libraries.
**/
function __autoload($class_name)
{
				//
		if (!class_exists($class_name) )
		{
			$class_name = str_replace(\"\\\",\"/\",$class_name);
			
			if ( file_exists(QOO_ROOT.'libraries/'.$class_name.'.php') )
				require_once(QOO_ROOT.'libraries/'.$class_name.'.php');
			else {
				echo \"<b>QOO::ERROR</b> Class $class_name could not be loaded because the required file <b>\".QOO_ROOT.'libraries/'.$class_name.'.php'.\"</b> does not exist.<br>\";
				die();
				}
		}

}


?>";
	
	$fh = fopen($application_directory."/init.php", "w" );
	fwrite( $fh, $init_content);
	fclose($fh);	
	
	print "Application directory created\n";
		
			
	break;
	default :
		echo "$option is an unknown option\n";
		printHelp();
	break;
}


?>
