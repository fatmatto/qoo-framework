
<!doctype html>

<html> 
<head> 
<title>qoo framework</title>

<meta charset="utf-8" />





<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->



<link rel="stylesheet" href="http://localhost/qoo-framework/demo/resources/css/style.css" type="text/css" />

</head>

<body>

<div id="page" >

		<div id="logo">
			<img src="http://localhost/qoo-framework/demo/resources/qoo_logo.png" />
			<h1 class="title">It Works!</h3>
		</div>
		
		
		<div id="logo">
		<?php 
			if(property_exists($view,'message') )
				echo $view->message;
		?>
		</div>
	

</div>



</body>

</html>
