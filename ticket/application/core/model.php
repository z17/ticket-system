<?php
class Model
{
	public $base;
	public $passkey;
	public $user;
	public $email;
	public $price;
	public $mrh_login;
	public $culture;
	public $mrh_pass1;
	public $mrh_pass2;
	function __construct()
	{ 
		session_start();
		
		$file = parse_ini_file("/application/conf.ini");		
		$this->email = $file['email'];
		$this->price = $file['price'];
		$this->mrh_login = $file['mrh_login'];
		$this->culture = $file['culture'];		
		$this->mrh_pass1 = $file['mrh_pass1'];		
		$this->mrh_pass2 = $file['mrh_pass2'];
		
		$this -> base = new Base;
		if (isset($_SESSION['userid']))
		{
			$useremail = $_SESSION['useremail'];
			$this -> user = $this -> base -> getUser($useremail);
		}
	}
    public function get_data()
    {
    }
}