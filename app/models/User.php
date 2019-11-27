<?php

class User
{

	private $db;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function login($login, $password)
	{
		$this->db->query('SELECT u.id, u.login, u.password, u.name, r.name AS role 
			FROM user u
			LEFT JOIN user_role ur ON ur.id_user = u.id
			LEFT JOIN role r ON r.id = ur.id_role
			WHERE login = :login');

		$this->db->bind(':login', $login);
		$row = $this->db->single();

		$hashed_password = $row->password;

		if (password_verify($password, $hashed_password)) {
			return $row;
		} else {
			return false;
		}
	}

	public function checkPassword($login, $password)
	{
		$this->db->query('SELECT id, login, password, name from user where login = :login');
		$this->db->bind(':login', $login);
		$row = $this->db->single();

		$hashed_password = $row->password;
		if (password_verify($password, $hashed_password)) {
			return $row;
		} else {
			return false;
		}
	}

	public function getUserByLogin($login)
	{
		$this->db->query('SELECT login FROM user WHERE login = :login');

		$this->db->bind(':login', $login);
		$this->db->single();

		// Check row
		if ($this->db->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserById($id)
	{
		$this->db->query('SELECT id, login, password, name FROM user WHERE id = :id');

		$this->db->bind(':id', $id);
		return $this->db->single();
	}

	public function getUsers()
	{
		$this->db->query('SELECT id, name, mail FROM user');
		return $this->db->resultSet();
	}
}
