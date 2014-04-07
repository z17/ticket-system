<?php
class Model_Profile extends Model
{
    public function get_data()
    {	
		
		$data['title'] = "Профиль";
		if (!isset($_SESSION['userid']))
		{
			Route::ErrorAccess();
		}
		$data['login'] = true;
		$data['user'] = $this -> user;		
		$data['fl'] = $this -> base -> isActiveQuestion($data['user']['id']);
		if ($data['fl']) 
		{
			$data['message'] = 'Ответ на Ваш <a href="/ticket/all" target="_blacnk">вопрос</a> будет дан в течении 1 суток';
		}
		return $data;		
    }
	
	public function get_edit_data()
    {
		if (!isset($_SESSION['userid']))
		{
			Route::ErrorAccess();
		}	
		
		$data['message'] = "";		// что бы не был пустым
		
		$data['newName'] = isset($_POST['newName']) ? $_POST['newName'] : NULL;
		$data['newPass1'] = isset($_POST['newPass1']) ? $_POST['newPass1'] : NULL;
		$data['newPass2'] = isset($_POST['newPass2']) ? $_POST['newPass2'] : NULL;
		$data['password'] = isset($_POST['password']) ? $_POST['password'] : NULL;
		$data['newPhone'] = isset($_POST['newPhone']) ? $_POST['newPhone'] : NULL;
		$data['fl'] = isset($_POST['fl']) ? $_POST['fl'] : false;
				
		$data['user'] = $this -> user;	 // получаем данные пользователя
		
		if ($data['fl']) // если отправили форму
		{
			$data['errors'] = array();
			
			if($data['newPass1'] != $data['newPass2'])
			{
				$str = "Новые пароли не совпадают";
				array_push($data['errors'],$str);
			}
			if(strlen($data['newPass1']) < 6 or strlen($data['newPass1']) > 20)
			{
				$str = "Пароль должен быть не меньше 6 символов и не больше 20";
				array_push($data['errors'],$str);
			}			
			if ($data['newPhone'] == NULL)
			{
				$str = "Телефон не установлен";
				array_push($data['errors'],$str);
			}
			if ($data['newName'] == NULL)
			{
				$str = "Имя не установлено";
				array_push($data['errors'],$str);
			}
			
			if ($data['password'] != $data['user']['password'])
			{
				$str = "Вы ввели неверный пароль";
				array_push($data['errors'],$str);
			}
			if (empty($data['errors']))
			{
				// если ошибок нет - обновляем
				$this -> base -> updateUser($data['user']['email'],$data['newPass1'],$data['newName'],$data['newPhone']);
				$data['message'] = "Профиль отредактирован";	
				$data['user']['name'] = $data['newName'];	// для обновления вывода в форме
				$data['user']['phone'] = $data['newPhone'];
			}
			else
			{
				$data['message'] = "Ошибка редактирования:";
				
			}
		}
		
		$data['title'] = "Редактировать профиль";
		return $data;
		
    }
	
}