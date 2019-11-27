<?php

class Controller
{
	private $editRule = ['admin'];

	public function model($model)
	{
		// Require model file
		require_once '../app/models/' . $model . '.php';

		//Instantiate model
		return new $model();
	}

	// Load view
	public function view($view, $data = [])
	{
		// Check for view file
		if (file_exists('../app/views/' . $view . '.php')) {
			require_once('../app/views/' . $view . '.php');
		} else {
			/// View does not exists
			die('View does not exists');
		}
	}

	/**
	 * Return array
	 */
	protected function getEditRule()
	{
		return $this->editRule;
	}

	/**
	 * Get query path
	 * Return array
	 */
	public function parseUrlQuery()
	{
		parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $query);
		return $query;
	}

	public function link($route, $args = '')
	{
		$url = CURREN_PAGE . $route . '?';

		if ($args) {
			if (is_array($args)) {
				$url .= http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
		}

		return $url;
	}
}
