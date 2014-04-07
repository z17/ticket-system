<?php
class Base {    
    private $base;
	private $host;
	private $baseName;
	private $user;
	private $login;
	private $pass;
	
    function __construct()
    {
		$file = parse_ini_file("/application/conf.ini");
		
		$this->host = $file['host'];
		$this->baseName = $file['baseName'];
		$this->user = $file['user'];
		$this -> base = new PDO("mysql:host=".$this->host.";dbname=".$this->baseName, $this->user); 
		$this -> base -> query("set names utf8");		 
    }    
	function isUser($email)
	{
		$sql = 'SELECT COUNT(id) FROM users WHERE email=:email';
		$sql = $this -> base -> prepare($sql);
		$sql -> bindParam (':email',$email,PDO::PARAM_STR);
		$sql -> execute();
		$user = 0;
		$user = $sql -> fetch();
		if ($user['COUNT(id)'] > 0)
			$fl = true;
		else
			$fl = false;
			
		return $fl;
	}
	function getUser($email)
	{
		$sql = 'SELECT * FROM users WHERE email=:email';
		$sql = $this -> base -> prepare($sql);
		$sql -> bindParam (':email',$email,PDO::PARAM_STR);
		$sql -> execute();
		$user = $sql -> fetch();
		return $user;
	}
	function getUserById($id)
	{
		$sql = 'SELECT * FROM users WHERE id=:id';
		$sql = $this -> base -> prepare($sql);
		$sql -> bindParam (':id',$id,PDO::PARAM_STR);
		$sql -> execute();
		$user = $sql -> fetch();
		return $user;
	}
	function addUser($email, $password, $name, $phone)
	{
		$id_group = 1;		// по умолчинию группа users
		$balance = 0;		// по умолчанию баланс 0
		$sql = 'INSERT INTO users (id_group, email, password, name, phone, balance) 
				VALUES (:id_group, :email, :password, :name, :phone, :balance)';
		$sql = $this->base -> prepare($sql);
		$sql -> bindParam (':id_group',$id_group,PDO::PARAM_INT);
		$sql -> bindParam (':email',$email,PDO::PARAM_STR);
		$sql -> bindParam (':password',$password,PDO::PARAM_STR);
		$sql -> bindParam (':name',$name,PDO::PARAM_STR);
		$sql -> bindParam (':phone',$phone,PDO::PARAM_STR);
		$sql -> bindParam (':balance',$balance,PDO::PARAM_INT);
		$a = $sql -> execute();
	}
	function updateUserBalansMin($user, $sum)
	{
		$balance = $user['balance'] - $sum;
		$id = $user['id'];
		$sql = 'UPDATE users SET balance = :balance	WHERE id = :id';
		$sql = $this -> base -> prepare($sql);
		$sql -> bindParam (':id',$id);
		$sql -> bindParam (':balance',$balance);
		$a = $sql -> execute();
	}
	function updateUser($email, $password, $name, $phone)
	{
		$sql = 'UPDATE users SET password = :password, name = :name, phone = :phone
				WHERE email = :email';
		$sql = $this -> base -> prepare($sql);
		$sql -> bindParam (':name',$name,PDO::PARAM_STR);
		$sql -> bindParam (':password',$password,PDO::PARAM_STR);
		$sql -> bindParam (':email',$email,PDO::PARAM_STR);
		$sql -> bindParam (':phone',$phone,PDO::PARAM_STR);
		$a = $sql -> execute();
	}
	function addTicket($id_user, $type, $topicname, $text)
	{	
		$sql = 'INSERT INTO tickets (id_user, type, topicname, text) 
				VALUES (:id_user, :type, :topicname, :text)';
		$sql = $this->base -> prepare($sql);
		$sql -> bindParam (':id_user',$id_user);
		$sql -> bindParam (':type',$type);
		$sql -> bindParam (':topicname',$topicname);
		$sql -> bindParam (':text',$text);
		$a = $sql -> execute();
	}	
	function getTicketsUsers($id_user)
	{
		$sql = 'SELECT * FROM tickets WHERE id_user=:id_user';
		//  ORDER BY id DESC
		$sql = $this->base -> prepare($sql);
		$sql -> bindParam (':id_user',$id_user);
		$sql -> execute();
		$posts = $sql -> fetchAll();
		return $posts;
	}
	function getTicketsAllActive()
	{	
		$type = "question";
		$sql = 'SELECT * FROM tickets WHERE type=:type';
		$sql = $this->base -> prepare($sql);
		$sql -> bindParam (':type',$type);
		$sql -> execute();
		$posts = $sql -> fetchAll();
		return $posts;
	}
	function getTicketsUserActive($id_user)
	{	
		$sql = 'SELECT * FROM tickets WHERE id_user=:id_user';
		$sql = $this->base -> prepare($sql);
		$sql -> bindParam (':id_user',$id_user);
		$sql -> execute();
		$posts = $sql -> fetchAll();
		return $posts;
	}
	function updateTicketsComplete($id_user)
	{
		$type = "completed";
		$typeQuestion = "question";
		$sql = 'UPDATE tickets SET type = :type
				WHERE id_user = :id_user and type = :typeQuestion';
		$sql = $this -> base -> prepare($sql);
		$sql -> bindParam (':id_user',$id_user);
		$sql -> bindParam (':type',$type);
		$sql -> bindParam (':typeQuestion',$typeQuestion);
		$a = $sql -> execute();
	}
	function isActiveQuestion($id_user)
	{
		$type = 'question';
		$sql = 'SELECT COUNT(id) FROM tickets WHERE id_user=:id_user and type=:type';
		$sql = $this->base -> prepare($sql);
		$sql -> bindParam (':id_user',$id_user);
		$sql -> bindParam (':type',$type);
		$sql -> execute();
		$posts = $sql -> fetch();
		if ($posts['COUNT(id)'] > 0)
			$fl = true;
		else
			$fl = false;
		return $fl;
	
	}
	function getPayId()
	{
		// возвращает следующее (последнее+1) значение id в таблице
		$sql = 'SELECT MAX(id) FROM paylog';
		$sql = $this->base -> prepare($sql);
		$sql -> execute();		
		$a = $sql -> fetch();
		if ($a['MAX(id)'] == NULL)
		{	
			return 1;
		}
		else
		{
			return $a['MAX(id)']+1;
		}
	}
}