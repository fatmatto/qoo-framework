<?php

/**
*
*	Standard error controller, you can add here your customization
*
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