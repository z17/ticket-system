<?php
class Model_Add extends Model
{
    public function get_data()
    {		
		$data['text'] = isset($_POST['text']) ? $_POST['text'] : NULL;	
		$data['fl'] = isset($_POST['fl']) ? $_POST['fl'] : false;	
		
		if (!isset($_SESSION['userid']))
		{
			Route::ErrorAccess();
		}
		else
		{
			$data['userFl'] = true;
			
			$user = $this -> user;
			$data['text'] = isset($_POST['text']) ? $_POST['text'] : NULL;	
			$data['topicname'] = isset($_POST['topicname']) ? $_POST['topicname'] : NULL;	
			$data['fl'] = isset($_POST['fl']) ? $_POST['fl'] : false;
			
			$data['errors'] = array();	
			
			if ($data['fl'] and $user['balance'] >= $this -> price ) 
			{					
				if ($user['balance'] < $this -> price)
				{					
					$str = "У вас на счету недостаточно денег для отправки вопроса";
					array_push($data['errors'],$str);
				}
				if (empty($data['errors']))
				{
					// если ошибок нет - отправляем
					$type = "question";
					$id_user = $this->user['id'];
					$data['text'] = strip_tags($data['text']);
					$data['text'] = str_replace("\n","<br>",$data['text']);
					$this -> base -> addTicket($id_user,$type,$data['topicname'],$data['text']);
					$this -> base -> updateUserBalansMin($this -> user,$this -> price);
					$data['message'] = "Вопрос задан, ответ на Ваш вопрос будет дан в течении 1 суток";	

					// письмо администратору
					$to = $this -> email; 
					$subject = 'Новый вопрос от Пользователя';
					
					//$message = 'Задан новый вопрос от пользователя. Вопрос:<br>Тема: '.$data['topicname'].'<br>'.$data['text'].'<br><br>Что бы ответить перейдите по <a href="'.$_SERVER['HTTP_HOST'].'/ticket/answer">ссылке</a>'; 
					$message = 'Задан новый вопрос от пользователя. Вопрос:';
					$message .= '<br>Тема: '.$data['topicname'].'<br>'.$data['text'];
					$message .= '<br><br>Что бы ответить перейдите по <a href="'.$_SERVER['HTTP_HOST'].'/ticket/answer">ссылке</a>';
					$message .= '<br><br>Данные пользователя:<br>Имя:'.$this->user['name'].'<br>email:'.$this->user['email'].'<br>Телефон:'.$this->user['phone'].'<br>';
					$mailheaders = "Content-type:text/html; charset=utf-8\r\n"; 
					$mailheaders .= "From: SiteRobot <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; 
					$mailheaders .= "Reply-To: noreply@".$_SERVER['HTTP_HOST']."\r\n"; 				
					mail($to, $subject, $message, $mailheaders);					
				}
				else
				{
					$data['message'] = "Ошибка отправки:";
					
				}
			}
			elseif ($user['balance'] < $this -> price)
			{
				$data['message'] = '<h2>Задайте вопрос</h2>';
				$str = "У вас на счету недостаточно денег для отправки вопроса";
				array_push($data['errors'],$str);
			}
			else	
			{
				$data['message'] = '<h2>Задайте вопрос</h2>';
				
				$data['pay']['mrh_login'] = $this -> mrh_login;
				$data['pay']['out_summ'] = $this -> price;
				$mrh_pass1 = $this -> mrh_pass1;
				$data['pay']['id'] = $this ->base -> getPayId();
				$data['pay']['crc'] = md5($data['pay']['mrh_login'].':'.$data['pay']['out_summ'].':'.$data['pay']['id'].':'.$mrh_pass1);
				$data['pay']['culture'] = $this -> culture;		
			}			
		}
		$data['price'] = '<p>Чтобы задать вопрос, необходимо совершить платеж в размере '.$this -> price.' руб за 1 вопрос</p>';
		$data['title'] = 'Задать вопрос';
		return $data;
    }
}