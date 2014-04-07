<?php
class Model_Answer extends Model
{
    public function get_data()
    {		
		if (!isset($_SESSION['userid']))
		{			
			Route::ErrorAccess();
		}
		if ($this -> user['id_group'] != 2)
		{		
			Route::ErrorAccess();
		}
		
		$data['posts'] = $this -> base -> getTicketsAllActive();
		$data['message'] = '<h1>Активные вопросы</h1>';
		$data['title'] = 'Активные вопросы';
		return $data;
    }
	
    public function get_user_data()
    {		
		if (!isset($_SESSION['userid']))
		{			
			Route::ErrorAccess();
		}
		if ($this -> user['id_group'] != 2)
		{		
			Route::ErrorAccess();
		}
		
		$data['text'] = isset($_POST['text']) ? $_POST['text'] : NULL;	
		$data['fl'] = isset($_POST['fl']) ? $_POST['fl'] : false;
		$data['text'] = trim($data['text']);
		
		$url = $_SERVER['REQUEST_URI'];
        $url = substr($url, strpos($url, '?'), strlen($url) - strpos($url, '?'));
		$routes = explode('/', $url);
		$data['id_author'] = $routes[3];
		
		$data['user'] = $this -> base -> getUserById($data['id_author']);
		if ($data['user']) 
		{			
			$data['posts'] = $this -> base -> getTicketsUserActive($data['id_author']);
			$data['message'] = '<h2>Вопросы от пользователя '.$data['user']['name'].'</h2><p>Отсортированы в хронологическом порядке (последние снизу)</p>';
			
			$data['errors'] = array();	
			if ($data['fl']) 
			{					
				if ($data['text'] == NULL or strlen($data['text']) == 0)
				{
					$str = "Вы не ввели текст вопроса";
					array_push($data['errors'],$str);
				}
				
				if (empty($data['errors']))
				{
					// если ошибок нет - отправляем
					$type = "answer";
					$id_user = $data['id_author'];
					$data['text'] = strip_tags($data['text']);
					$data['text'] = str_replace("\n","<br>",$data['text']);
					$topicname = 'Ответ';
					$this -> base -> addTicket($id_user,$type,$topicname,$data['text']);
					$this -> base -> updateTicketsComplete ($id_user);
					$data['messageForm'] = "Ответ отправлен<br>";	
					$data['posts'] = $this -> base -> getTicketsUserActive($data['id_author']);	// что бы обновить переписку


					// письмо пользователю об ответе
					$to = $data['user']['email']; 
					$subject = 'На ваш вопрос на сайте '.$_SERVER['HTTP_HOST'].' ответили';					
					$message = 'Здравствуйте!<br>На ваш вопрос ответили.';
					$message .= '<br>Что бы прочитать ответ перейдите по <a href="'.$_SERVER['HTTP_HOST'].'/ticket/all">ссылке</a><br>';
					$mailheaders = "Content-type:text/html; charset=utf-8\r\n"; 
					$mailheaders .= "From: SiteRobot <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; 
					$mailheaders .= "Reply-To: noreply@".$_SERVER['HTTP_HOST']."\r\n"; 				
					mail($to, $subject, $message, $mailheaders);	
				}
				else
				{
					$data['messageForm'] = "Ошибка отправки:";
					
				}
			}
		}
		else
		{
			$data['message'] = '<p>Такого пользователя не существует</p>';
		} 
			$data['title'] = 'Активные вопросы';
		return $data;
    }
	
}