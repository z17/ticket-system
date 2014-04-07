<?php
class Model_Register extends Model
{
    public function get_data()
    {				
	
		$data['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;
		$data['pass1'] = isset($_POST['pass1']) ? $_POST['pass1'] : NULL;
		$data['pass2'] = isset($_POST['pass2']) ? $_POST['pass2'] : NULL;
		$data['name'] = isset($_POST['name']) ? $_POST['name'] : NULL;
		$data['phone'] = isset($_POST['phone']) ? $_POST['phone'] : NULL;		
		$data['fl'] = isset($_POST['fl']) ? $_POST['fl'] : false;
		
		$data['email'] = trim($data['email']); // убираем пробелы
				
		if ($data['fl']) 
		{
			$data['errors'] = array();
			
			$is_user = $this -> base -> isUser($data['email']);
			if ($is_user)
			{
				$str = "Такой e-mail уже зарегестрирован";
				array_push($data['errors'],$str);
			}
			if($data['pass1'] != $data['pass2'])
			{
				$str = "Пароли не совпадают";
				array_push($data['errors'],$str);
			}
			if(strlen($data['pass1']) < 6 or strlen($data['pass1']) > 20)
			{
				$str = "Пароль должен быть не меньше 6 символов и не больше 20";
				array_push($data['errors'],$str);
			}
		/*	if (!preg_match("/^(?:[a-z0-9]+(?:[-_]?[a-z0-9]+)?@[a-z0-9]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",$data['email']))
			{
				$str = "Некорректный e-mail";
				array_push($data['errors'],$str);
			}
		*/
			if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){

                $str = "Некорректный e-mail";
				array_push($data['errors'],$str);
			}
			if (empty($data['errors']))
			{
				// если ошибок нет - регистрируем
				$this -> base -> addUser($data['email'],$data['pass1'],$data['name'],$data['phone']);
				$data['message'] = "Регистрация прошла успешно, <a href=\"/ticket/login\">войти</a>";	
				$data['formFl'] = false;
				
				// письмо пользователю
				$to = $data['email']; 
				$subject = 'Данные регистрации на сайте '.$_SERVER['HTTP_HOST'];
				$message = 'Вы успешно зарегистрировались на сайте '.$_SERVER['HTTP_HOST'].'<br>Регистрационные данные:<br>E-Mail:'.$data['email'].'<br>Пароль:'.$data['pass1'].'<br><br>'; 
				$mailheaders = "Content-type:text/html; charset=utf-8\r\n"; 
				$mailheaders .= "From: SiteRobot <noreply@".$_SERVER['HTTP_HOST'].">\r\n"; 
				$mailheaders .= "Reply-To: noreply@".$_SERVER['HTTP_HOST']."\r\n"; 
				
				mail($to, $subject, $message, $mailheaders);
				
				// письмо администратору				
				$to = $this->email;
				$subject = 'Новый пользователь на сайте '.$_SERVER['HTTP_HOST'];
				$message = 'Новый пользователь зарегистрировался на сайте '.$_SERVER['HTTP_HOST'].'<br>Регистрационные данные:<br>E-Mail:'.$data['email'].'<br>Пароль:'.$data['pass1'].'<br><br>'; 
				mail($to, $subject, $message, $mailheaders);
			}
			else
			{
				$data['message'] = "Ошибка регистрации:";
				$data['formFl'] = true;
				
			}
		}
		else	
		{
			$data['message'] = 'Заполните форму регистрации';
			$data['formFl'] = true;
		}
		
		$data['title'] = 'Регистрация';
		return $data;
    }
}