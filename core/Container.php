<?php

namespace Core;

class Container
{
	public static function newController($controller)
	{
		if (!file_exists(__DIR__.'/../app/Controllers/'.$controller.'.php') or !class_exists("App\\Controllers\\".$controller))
		{
			echo 'Página de Erro!';
			exit;
		}

		$objController = "App\\Controllers\\".$controller;
		return new $objController;
	}
}