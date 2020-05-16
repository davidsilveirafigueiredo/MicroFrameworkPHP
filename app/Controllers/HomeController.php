<?php

namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{
	public function index()
	{
		$this->setPageTitle('Página Inicial');
		$this->view->nome = "David Junior";

		$this->renderView("home/index", "layout");
	}
}