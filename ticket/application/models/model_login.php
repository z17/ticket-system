<?php
class Model_Login extends Model
{
    public function get_data()
    {				
		if (!isset($_SESSION['userid']))
		{
			$data['email'] = isset($_POST['email']) ? $_POST['email'] : NULL;
			$data['password'] = isset($_POST['password']) ? $_POST['password'] : NULL;
			$data['fl'] = isset($_POST['fl']) ? $_POST['fl'] : false;
			
			$data['message'] = '';
			if ($data['fl']) 
			{
				$user = $this -> base -> getUser($data['email']);
				if ($user)
				{
					if ($data['password'] == $user['password'])
					{
						$data['message'] = 'Вход выполнен, <a href="/ticket/profile">Профиль</a>';
						$data['formFl'] = false;
						$_SESSION['userid'] = $user['id'];
						$_SESSION['useremail'] = $user['email'];
					}
					else
					{
						$data['error'] = 'Неправильный email или пароль';
						$data['formFl'] = true;
					}
				}
				else
				{
					$data['error'] = 'Неправильный email или пароль';
					$data['formFl'] = true;
				}			
			}
			else	
			{
				$data['message'] = 'Заполните форму';
				$data['formFl'] = true;
			}		
		}
		else
		{
			$data['message'] = "Вы уже авторизованы";
			$data['formFl'] = false;
		}
		$data['title'] = 'Авторизация';
		return $data;		
    }
}