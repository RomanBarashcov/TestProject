<?php

/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{

	static function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'Accounts';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// получаем имя контроллера
		if ( !empty($routes[1]) )
		{	
			$controller_name = $routes[1];
		}
		
		// получаем имя экшена
		if ( !empty($routes[2]) )
		{
			$action_name = $routes[2];
		}

		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		/*
		echo "Model: $model_name <br>";
		echo "Controller: $controller_name <br>";
		echo "Action: $action_name <br>";
		*/

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

		//маршрутизация
			if(method_exists($controller, $action))
			{
				switch ($action)
				{
					case "action_login":
						if(isset($_POST['email']) && isset($_POST['password']))
						{
							$email = $_POST['email'];
							$password = $_POST['password'];
							$controller->$action($email, $password);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_facebook_auth":
						if(isset($_POST['Email']))
						{
							$email = $_POST['Email'];
							$controller->$action($email);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_register":
						if(isset($_POST['email']) && isset($_POST['password']))
						{
							$email = $_POST['email'];
							$password = $_POST['password'];
							$controller->$action($email, $password);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_create":
						if(isset($_POST['new_msg']) && isset($_POST['author_id']))
						{
							$msg = $_POST['new_msg'];
							$author_id = $_POST['author_id'];
							$controller->$action($msg, $author_id);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_update_message":
						if(isset($_POST['new_message']) && isset($_POST['message_id']))
						{
							$new_msg = $_POST['new_message'];
							$message_id = $_POST['message_id'];
							$controller->$action($new_msg, $message_id);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_remove_msg":
						if(isset($_POST['rem_msg_id']))
						{
							$rem_msg_id = $_POST['rem_msg_id'];
							$controller->$action($rem_msg_id);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_create_comment":
						if(isset($_POST['comment']) && isset($_POST['parent_id']) && isset($_POST['msg_id']) && isset($_POST['author_id']))
						{
							$new_comment = $_POST['comment'];
							$parent_id = $_POST['parent_id'];
							$msg_id = $_POST['msg_id'];
							$author_id = $_POST['author_id'];
							$controller->$action($new_comment, $parent_id, $msg_id, $author_id);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_update_comment":
						if(isset($_POST['up_comment']) && isset($_POST['comment_id']) && isset($_POST['parent_id']))
						{
							$up_comment = $_POST['up_comment'];
							$comment_id = $_POST['comment_id'];
							$parent_id = $_POST['parent_id'];
							$controller->$action($up_comment, $comment_id, $parent_id);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case "action_remove_comment":
						if(isset($_POST['rem_comment_id']))
						{
							$rem_comment_id = $_POST['rem_comment_id'];
							$controller->$action($rem_comment_id);
						}
						else{
							Route::ErrorPage404();
						}
						break;
					case $action:
						$controller->$action();
						break;
				}
			}
			else
			{
				Route::ErrorPage404();
			}


	}

	function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
    }
    
}
