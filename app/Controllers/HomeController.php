<?php

namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{
	public function index()
	{
		$nome = 'David';
		$sobre = 'Junior';

		$this->renderView("home/index", compact('nome', 'sobre'));
	}
}