# qoo framework 

qoo is a lightweight php mvc framework, implementing a comlpete front controller pattern.

## Hello World

Create a new directory and a index.php file inside of it, the put the following content iinto index.php:

```php
{{{
  require('path/to/qoo/init.php');
  
  try {
  $fc = new \qoo\controller\FrontController();
  $view = new \qoo\controller\View();
  $view->setView('default');
  $fc->dispatcher->setControllerParameters( array('view' => $view) );
  
  
  $fc->router->createRoute('index')
    			->map('')
  				->setParam('controller','DefaultController')
  				->setParam('action' , 'index');

  $fc->dispatcher->useDefaults(true);//We force the usage of default view and controller shipped with qoo as a demo
  $fc->dispatch();

  }catch (\qoo\core\Exception   $e)
  {
    $h = new \qoo\core\ExceptionHandler();
    $h->printHtmlReport($e);
    
  }
}}}
```
