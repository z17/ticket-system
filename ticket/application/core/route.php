<?php
class Route
{
    static function start()
    {
		// контроллер и действие по умолчанию
        $controller_name = 'Main';
        $action_name = 'index';
		
		// вырезаем get запросы из обрабатываемого url
		$url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '?'))
			{
				 $url = substr($url, 0, strpos($url, '?'));
			}
		
		$routes = explode('/', $url);
        // получаем имя контроллера
        if ( !empty($routes[2]) )
        {	
            $controller_name = $routes[2];
        }
        
        // получаем имя экшена
        if ( !empty($routes[3]) )
        {
            $action_name = $routes[3];
        }

        // добавляем префиксы
        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;

        // подцепляем файл с классом модели (файла модели может и не быть)

        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;
        if(file_exists($model_path))
        {
            include "application/models/".$model_file;
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;
        if(file_exists($controller_path))
        {
            include "application/controllers/".$controller_file;
        }
        else
        {
            Route::ErrorPage404();
        }
        
        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;
        
        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
			$action_default = 'action_default';
			// если есть экшен по умолчанию, вызываем его, если нет - 404
			// сделано дабы можно было реализовать страницы page/1 page/2 или ЧПУ
			// возможно чушь
			if(method_exists($controller, $action_default))
			{	
				$controller->$action_default();
			}	
			else {
				Route::ErrorPage404();
			}
        }
    
    }
    
    function ErrorPage404()
    {
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
        header('Location:'.$host.'ticket/errors/404');
    }
	function ErrorAccess()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('Location:'.$host.'ticket/errors/access');
    }
}