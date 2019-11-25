<?php

class Tasks extends Controller{

	//Pagination
	private $limit 	 = 3;	//Limit per page
	private $pages;	
	private $current_page;
	private $total;
	
	// URL
	private $url_path;

	//state default
	private $state = 1; //Pending 

	public function __construct(){

		$this->taskModel = $this->model('Task');
		$this->userModel = $this->model('User');

		$this->pageInfo();
	}

	public function index(){

		$data['start'] = ($this->current_page -1) * $this->limit;
		$data['limit'] = $this->limit;

		$path = $this->url_path;

		if(isset($path['sort'])) {
			$data['sort'] = $path['sort'];
		}

		if (isset($path['order'])) {
			$data['order'] = $path['order'];
		}

		$tasks = $this->taskModel->getTasks($data);

		// Load sort view
		$sort = $this->sort();

		// Load pagination view
		$pagination = $this->pagination();

		$allow_edit = ( isset($_SESSION['user_id']) && in_array($_SESSION['user_role'], $this->getEditRule()) ) ? true : false;
		
		$data = [
			'tasks' => $tasks,
			'pagination' => $pagination,
			'allow_edit' => $allow_edit,
			'sort'		 => $sort
		];

		$this->view('tasks/index', $data);
	}

	public function add(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
			// Sanitize POST Array
			$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

			$data = [
				'name' 		 => trim($_POST['name']),
				'email' 	 => trim($_POST['email']),
				'body' 		 => trim($_POST['body']),
				'user_id' 	 => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1,
				'state' 	 => $this->state,
				'name_error' => '',
				'email_error'=> '',
				'body_error' => ''
			];

			// Validate
			if( empty($data['name']) ){
				$data['name_error'] = 'Please enter the name';
			}
			if( empty($data['email']) ){
				$data['email_error'] = 'Please enter the email';
			}elseif( filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false){
				$data['email_error'] = 'Email address not valid';
			}
			if( empty($data['body']) ){
				$data['body_error'] = 'Please enter the body';
			}

			// Make sure no errors
			if ( empty($data['name_error']) && empty($data['email_error']) && empty($data['body_error']) ){
				// Validated
				if( $this->taskModel->addTask($data) ){
					message('task_message', 'Task Added');
					redirect('tasks');
				} else{
					die('Something went wrong');
				}
			} else {
				// Load the view
				$this->view('tasks/add', $data);
			}

		} else{
			$data = [
				'name' => '',
				'email' => '',
				'body' => ''
			];
			$this->view('tasks/add', $data);
		}

		}

	public function edit($id){

		if($_SERVER['REQUEST_METHOD']=='POST'){

			if(!isLoggedIn() ){
				message('access_denied_message', 'Access is denied', 'alert alert-danger alert-dismissible fade show');
				redirect('users/login');
				exit;
			}
			
			// Sanitize POST Array
			$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
			$state_map =  $this->taskModel->getState();
			
			$data = [
				'id' => $id,
				'name' => trim($_POST['name']),
				'email' => trim($_POST['email']),
				'body' => trim($_POST['body']),
				'state' => (int) $_POST['state'],
				'state_map' => $state_map,
				'user_id' => $_SESSION['user_id'],
				'name_error' => '',
				'email_error' => '',
				'body_error' => '',
				'state_error' => ''
			];

			// Validate
			if( empty($data['name']) ){
				$data['name_error'] = 'Please enter the name';
			}
			if( empty($data['email']) ){
				$data['email_error'] = 'Please enter the email';
			}
			if( empty($data['body']) ){
				$data['body_error'] = 'Please enter the body';
			}
			if( $data['state'] < 1 ){
				$data['state_error'] = 'Please enter the state';
			}

			// Make sure no errors
			if ( empty($data['name_error']) && empty($data['email_error']) &&  empty($data['body_error']) &&  empty($data['state_error'])){
				// Validated
				if( $this->taskModel->updateTask($data) ){
					message('task_message', 'Task Updated');
					redirect('tasks');
				} else{
				die('Something went wrong');
				}
			} else {
				// Load the view
				$this->view('tasks/edit', $data);
			}

		} else{
			// Get existing task from model
			$task = $this->taskModel->getTaskById($id);
			$state_map =  $this->taskModel->getState();

			//Check for rule
			if( !in_array($_SESSION['user_role'], $this->getEditRule()) ){
				redirect('tasks');
			}
			
			$data = [
				'id' => $task->id,
				'name' => $task->name,
				'email' => $task->email,
				'body' => $task->body,
				'state' => $task->state,
				'state_map' => $state_map,
				'name_error' => '',
				'email_error' => '',
				'body_error' => '',
				'state_error' => ''
			];
			$this->view('tasks/edit', $data);
		}

	}

	public function show($id){
		$task = $this->taskModel->getTaskById($id);
		$user = $this->userModel->getUserById($task->user_id);

		$allow_edit = ( isset($_SESSION['user_id']) && in_array($_SESSION['user_role'], $this->getEditRule()) ) ? true : false;

		$data = [
			'task' => $task,
			'user' => $user,
			'allow_edit' => $allow_edit,
		];

		$this->view('tasks/show', $data);
	}


	public function delete($id){

		if($_SERVER['REQUEST_METHOD']=='POST') {
			
			if(!isLoggedIn() ){
				redirect('users/login');
			}

			// Get existing task from model
			$task = $this->taskModel->getTaskById($id);

			//Check for rule
			if( !in_array($_SESSION['user_role'], $this->getEditRule()) ){
				redirect('tasks');
			}
			if( $this->taskModel->deleteTasks($id) ){
				message('task_message', 'Task removed');
				redirect('tasks');
			} else {
				die('Something went wrong');
			}

		} else {
			redirect('tasks');
		}
	} 

	private function pageInfo(){

		$this->total 	= $this->taskModel->getTotalTask();
		$this->pages 	= ceil($this->total  / $this->limit);
		$this->url_path = $this->parseUrlQuery();

		$num = isset($this->url_path['page']) ? (int) $this->url_path['page'] : 1;
		$this->current_page = max(min($num, $this->pages), 1);

	}

	private function pagination(){

		$path = $this->url_path;

		$url = [];
		$pages = [];

		if ($path) {
			if (isset($path['sort'])) {
				$url['sort'] = $path['sort'];
			}

			if (isset($path['order'])) {
				$url['order'] = $path['order'];
			}
			if (isset($path['page'])) {
				$url['page'] = $path['page'];
			}
		}

		for($i = 1; $i <= $this->pages; $i++){
			$url['page'] = $i;
			$pages[$i] = $this->link('mvc/tasks', $url);
		}
		
		$previous = [];
		if($this->current_page == 1){
			$previous['state'] 	= false;
			$url['page'] 		= $this->current_page;
			$previous['link'] 	= $this->link('mvc/tasks', $url);
		}else{
			$previous['state'] 	= true;
			$url['page'] 		= $this->current_page - 1;
			$previous['link'] 	= $this->link('mvc/tasks', $url);
		}

		$next = [];
		if($this->current_page == $this->pages){
			$next['state'] 	= false;
			$url['page'] 	= $this->current_page;
			$next['link'] 	= $this->link('mvc/tasks', $url);
		}else{
			$next['state'] 	= true;
			$url['page'] 	= $this->current_page + 1;
			$next['link'] 	= $this->link('mvc/tasks', $url);
		}

		$data = [
			'total' 	=> $this->total,
			'current' 	=> $this->current_page,
			'previous' 	=> $previous,
			'next' 		=> $next,
			'pages' 	=> $pages
		];

		return $data;
	}

	public function sort(){

		$path = $this->url_path;

		$filters = [
			['sort' => 't.created_at', 'order' => 'DESC', 'label' => 'Default'],
			['sort' => 't.name', 'order' => 'ASC', 'label' => 'Name (A-Z)'],
			['sort' => 't.name', 'order' => 'DESC', 'label' => 'Name (Z-A)'],
			['sort' => 't.email', 'order' => 'ASC', 'label' => 'Email (A-Z)'],
			['sort' => 't.email', 'order' => 'DESC', 'label' => 'Email (Z-A)'],
			['sort' => 't.state', 'order' => 'ASC', 'label' => 'State (A-Z)'],
			['sort' => 't.state', 'order' => 'DESC', 'label' => 'State (Z-A)'],
		];

		$url = [];
		$data = [];

		if ($path) {
			if (isset($path['sort'])) {
				$url['sort'] = $path['sort'];
			}

			if (isset($path['order'])) {
				$url['order'] = $path['order'];
			}

			if (isset($path['page'])) {
				$url['page'] = $path['page'];
			}

			$data['current'] = $this->link('mvc/tasks', $url);
		}

		

		foreach($filters as $filter){
			$label = $filter['label'];
			unset($filter['label']);

			//$filter = array_merge($url, $filter);
			if(isset($url['page']))
				$filter['page'] = $url['page'];

			$link = $this->link('mvc/tasks', $filter);
			$data['url'][] = [
				'label' => $label,
				'link' 	=> $link
			];
		} 

		return $data;

	}

}