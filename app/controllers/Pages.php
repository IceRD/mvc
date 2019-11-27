<?php

use App\Lib;

class Pages extends Controller
{

	public function index()
	{
		$data = [
			'title' => 'Hello Task!',
			'description' => ''
		];
		$this->view('pages/index', $data);
	}
}
