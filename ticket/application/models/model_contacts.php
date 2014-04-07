<?php
class Model_Contacts extends Model
{
    public function get_data()
    {				
		$data['email'] = $this -> email;
		$data['phone'] = $this -> phone;
		$data['icq'] = $this -> icq;
		$data['navkac'] = 'contacts';
		$data['title'] = "Контакты";
		return $data;
		
    }
}