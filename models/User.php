<?php

class User 
{
	
	private $id;
	private $name;
	private $last_name;
	private $email;
	private $password;
	private $img;
	private $db;

	public function __construct() 
	{
		$this->db = new Connection();
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setLastName($last_name) {
		$this->last_name = $last_name;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function setImg($img) {
		$this->img = $img;
	}


	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getLastName() {
		return $this->last_name;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getImg() {
		return $this->db->quote($this->img);
	}


	public function save() {
		$sql = "INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (:name, :last_name, :email, :password)";
		$statement = $this->db->prepare($sql);
		$result = $statement->execute(array(
			':name' => $this->getName(),
			':last_name' => $this->getLastName(),
			':email' => $this->getEmail(),
			':password' => password_hash($this->getPassword(), PASSWORD_BCRYPT, ['cost' => 4])
		));

		return $result;
	}

	public function login() {

		$result = false;

		// Comprobar si existe el usuario
		$sql = "SELECT * FROM usuarios WHERE email = :email";
		$statement = $this->db->prepare($sql);
		if ($statement->execute(array(':email' => $this->getEmail()))) {
			
			$users = $statement->fetchAll(PDO::FETCH_OBJ);
			
			$verify = false;
			
			foreach ($users as $user) {
				$verify = password_verify($this->getPassword(), $user->password);
			}

			if ($verify) {
				$result = $users;
			}
		}
		
		return $result;
	}

	public function logOut() {
		if (isset($_SESSION['identity'])) {
			unset($_SESSION['identity']);
		}

		header('Location:' . base_url);
	}
	
}
