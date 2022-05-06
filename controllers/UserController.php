<?php

require_once 'models/User.php';

class UserController {
    public function index(){
		echo 'Metodo index de la clase UserController';
	}

	public function signUp() {
		include 'views/user/sign-up.php';
	}
	

	public function save() {
		
		if (isset($_POST)) {
			$name = isset($_POST['name']) ? $_POST['name'] : false;
			$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;

			if ($name && $last_name && $email && $password) {
				$user = new User();
				$user->setName($name);
				$user->setLastName($last_name);
				$user->setEmail($email);
				$user->setPassword($password);
	
				$save = $user->save();
	
				if ($save) {
					$_SESSION['register'] = 'complete';
				} else {
					$_SESSION['register'] = 'failed';
				}
				
			} else {
				$_SESSION['register'] = 'failed';

			}

		} else {
			$_SESSION['register'] = 'failed';
			
		}

		// header('location:' . base_url);
		echo '<script>window.location.href = "'.base_url.'"</script>';

	}

	public function signIn() {
		include 'views/user/sign-in.php';
	}

	public function login() {
		if (isset($_POST)) {
			// Identificar al usuario
			// Consulta a la base de datos
			$user = new User();
			$user->setEmail($_POST['email']);
			$user->setPassword($_POST['password']);
			$identity = $user->login();
			
			if ($identity && is_array($identity)) {
				$_SESSION['identity'] = $identity[0];

			} else {
				$_SESSION['error_login'] = 'Identificacion fallida!!';
			}

		}

		// header('Location:' . base_url);
		echo '<script>window.location.href = "'.base_url.'"</script>';
	}

	public function signOut() {

		if (isset($_SESSION['identity'])) {
			unset($_SESSION['identity']);
		}

		// header('Location:' . base_url . '/Product/index');
		echo '<script>window.location.href = "'.base_url.'/Product/index"</script>';
	}
}