<?php

class Users extends Controller
{

	public function __construct()
	{

		$this->userModel = $this->model('User');
		$this->taskModel = $this->model('Task');
	}

	public function index()
	{

		$users = $this->userModel->getUsers();
		$data = [
			'users' => $users
		];

		return $this->view('users/index', $data);
	}

	public function login()
	{

		if (isLoggedIn()) {
			redirect('tasks');
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				'login' => trim($_POST['login']),
				'password' => trim($_POST['password']),
				'login_error' => '',
				'password_error' => '',
			];

			// Validate login
			if (empty($data['login'])) {
				$data['login_error'] = 'Login required';
			} else if (!$this->userModel->getUserByLogin($data['login'])) {
				// User not found
				$data['login_error'] = 'User not found!';
			}

			// Validate password
			if (empty($data['password'])) {
				$data['password_error'] = 'Password required';
			}

			if (empty($data['login_error']) && empty($data['password_error'])) {
				// Validated
				// Check and set logged in user
				$userAuthenticated = $this->userModel->login($data['login'], $data['password']);
				if ($userAuthenticated) {
					// Create session
					$this->createUserSession($userAuthenticated);
				} else {
					$data = [
						'login' => trim($_POST['login']),
						'password' => '',
						'login_error' => 'Login or Password are incorrect',
						'password_error' => 'Login or Password are incorrect',
					];
					$this->view('users/login', $data);
				}
			} else {
				// Load view with errors
				$this->view('users/login', $data);
			}
		} else {
			// Init data
			$data = [
				'login' => '',
				'password' => '',
				'login_error' => '',
				'password_error' => '',
			];
			// Load view
			$this->view('users/login', $data);
		}
	}

	public function logout()
	{
		unset($_SESSION['user_id']);
		unset($_SESSION['user_login']);
		unset($_SESSION['user_name']);
		unset($_SESSION['user_role']);
		session_destroy();
		redirect('users/login');
	}

	public function createUserSession($user)
	{
		$_SESSION['user_id'] = $user->id;
		$_SESSION['user_login'] = $user->login;
		$_SESSION['user_name'] = $user->name;
		$_SESSION['user_role'] = $user->role;
		redirect('tasks');
	}

	public function isLoggedIn()
	{
		if (isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['user_login']) && isset($_SESSION['user_role'])) {
			return true;
		} else {
			return false;
		}
	}
}
