<?php

namespace Core;

use Core\Container;

class Route
{
	private $routes;

	public function __construct(array $routes)
	{
		$this->routes = $routes;
		$this->run();
	}

	private function getUrl()
	{
		return $this->removeBarraFinal( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
	}

	private function setRoutes($routes)
	{
		$newRoutes = [];
		foreach ($routes as $route)
		{
			$explode = explode('@', $route[0]);
			$r = [ $route[0], $explode[0], $explode[1] ];
			$newRoutes = $r;
		}
		$this->routes = $newRoutes;
	}

	private function removeBarraFinal($url)
	{
		if (!$url or strlen($url) <= 1)
			return $url;

		if ($url[ strlen($url) - 1 ] == "/")
			return substr($url, 0, strlen($url) - 1);

		return $url;
	}

	private function getRequest()
	{
		$obj = new \stdClass();

		foreach ($_GET as $key => $value) {
			$obj->get->$key = $value;
		}

		foreach ($_POST as $key => $value) {
			$obj->post->$key = $value;
		}

		return $obj;
	}

	private function run()
	{
		$url = $this->getUrl();
		$urlArray = explode('/', $url);
		$params = [];
		$found = false;

		foreach ($this->routes as $route)
		{
			$routeArray = explode('/', $this->removeBarraFinal($route[0]));

			if ( count($routeArray) != count($urlArray) )
				continue;
			
			for ($i = 0 ; $i < count($routeArray) ; $i++)
			{
				if ( preg_match('/[{][\w]+[}]/', $routeArray[ $i ]) )//if ( (strpos($routeArray[ $i ], "{") !== false) )
				{
					$routeArray[ $i ] = $urlArray[ $i ];
					$params[] = $urlArray[ $i ];
				}
				else if (($routeArray[ $i ] !== $urlArray[ $i ]))
					break;
			}

			if ( implode($routeArray, "/") == implode($urlArray, "/") )
			{
				$found = true;
				$acao = explode('@', $route[1]);
				$controller = $acao[0];
				$action = $acao[1];

				break;
			}
		}

		if ($found)
		{
			$controller = Container::newController($controller);
			if (method_exists($controller, $action))
			{
				$getPost = $this->getRequest();
				if (count((array)$getPost))
					$params[] = $getPost;
				$controller->$action(...$params);
			}
			else
			{
				echo 'Página de Erro!';
				exit;
			}
		}
		else
			Container::pageNotFound();
	}
}