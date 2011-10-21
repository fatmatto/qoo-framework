<?php
/**
*
*
*	Copy this file into your APP_NAME/controller directory
*
**/
class ErrorController extends \qoo\controller\Controller
{
	
	public function _404()
	{
		$this->view->setView('404');
		$this->response->append($this->view->render() );
	}
	
	public function index()
	{
		$this->view->setView('default_error');
		$this->response->append($this->view->render() );
	}
}

?>