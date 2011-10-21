<?php

/**
*
*	Demo Controller
*
**/
class DefaultController extends \qoo\controller\Controller
{
	public function index()
	{
		$this->response->append($this->view->render() );
	}
	
	public function testError()
	{
		$this->__error();
	}
	
	public function testException()
	{
		throw new \qoo\core\Exception('This is a test exception generater from the DefaultController');
	}
	
	public function testForward()
	{
		//This completely replace the current response with the response created by the forwarded action
		$this->response = $this->__forward('index','DefaultController'); 
	}
	
	public function testParameter()
	{
		$name = ucfirst($this->request->getParam('name'));
		
		$this->view->assign('message','Hello '.$name);
		
		$this->response->append( $this->view->render() );
	}
	
	public function phpInfo()
	{
		echo phpinfo();
	}
	
}

?>
