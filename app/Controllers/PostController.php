<?php

namespace App\Controllers;

use Core\BaseController;

class PostController extends BaseController
{
	public function index()
	{
		echo "Post";
	}

	public function show($i)
	{
		var_dump($i);
	}
}