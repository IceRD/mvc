<?php

class Task
{

	private $db;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function getTasks($data = [])
	{

		$sql = "SELECT t.id AS task_id, t.user_id, u.name, u.login, t.name, t.email, t.body, t.state, ts.name AS state_name, t.created_at, r.name AS role
			FROM tasks t 
			LEFT JOIN user u ON u.id = t.user_id 
			LEFT JOIN user_role ur ON ur.id_user = u.id
			LEFT JOIN role r ON r.id = ur.id_role
			LEFT JOIN task_state ts ON ts.id = t.state";

		$sort_data = array(
			't.name',
			't.email',
			't.state',
			't.created_at'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
		} else {
			$sql .= " ORDER BY t.created_at";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		$sql .= " LIMIT :start, :limit";

		$this->db->query($sql);

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$this->db->bind(':start', $data['start']);
			$this->db->bind(':limit', $data['limit']);
		}

		return $this->db->resultSet();
	}

	public function getTaskById($id)
	{
		$this->db->query('SELECT id, user_id, name, email, body, state, created_at FROM tasks WHERE id = :id');
		$this->db->bind(':id', $id);
		return $this->db->single();
	}

	public function getTaskByUserId($user_id)
	{
		$this->db->query('SELECT count(*) AS total FROM tasks WHERE user_id = :user_id');
		$this->db->bind(':user_id', $user_id);
		return $this->db->single();
	}

	public function addTask($data)
	{
		$this->db->query('INSERT INTO tasks (user_id, name, email, body, state) VALUES (:user_id, :name, :email, :body, :state)');
		// Bind VALUES
		$this->db->bind(':user_id', $data['user_id']);
		$this->db->bind(':name', $data['name'], PDO::PARAM_STR);
		$this->db->bind(':email', $data['email'], PDO::PARAM_STR);
		$this->db->bind(':body', $data['body'], PDO::PARAM_STR);
		$this->db->bind(':state', $data['state'], PDO::PARAM_INT);

		// Execute
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function getState()
	{
		$this->db->query('SELECT id, name FROM task_state');
		return $this->db->resultSet();
	}

	public function getStateById($id)
	{
		$this->db->query('SELECT id, name FROM task_state WHERE id = :id');
		$this->db->bind(':id', $id);
		return $this->db->resultSet();
	}

	public function updateTask($data)
	{
		$this->db->query('UPDATE tasks 
			SET name = :name, email = :email, body = :body, state = :state
			WHERE id = :id');
		// Bind VALUES
		$this->db->bind(':id', $data['id']);
		$this->db->bind(':name', $data['name']);
		$this->db->bind(':email', $data['email']);
		$this->db->bind(':body', $data['body']);
		$this->db->bind(':state', $data['state']);

		// Execute
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteTasks($id)
	{
		$this->db->query('DELETE FROM tasks WHERE id = :id');
		// Bind VALUES
		$this->db->bind(':id', $id);

		// Execute
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function getTotalTask()
	{
		$this->db->query('SELECT count(id) FROM tasks');
		$this->db->execute();
		return $this->db->fetchCount();
	}
}
