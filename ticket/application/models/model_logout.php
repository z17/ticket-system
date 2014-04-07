<?php
class Model_Login extends Model
{
	public function get_data()
	{
		if (!isset($_SESSION['userid']))
		{
			$data['message'] = "Для выхода необходимо авторизоваться";
		}
		else
		{
			session_destroy();
			$data['message'] = "Выход выполнен";
		}
	
		$data['title'] = "Выход";
		return $data;
	}
}