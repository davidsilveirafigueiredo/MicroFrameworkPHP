<?php

$route[] = ['/', 'HomeController@index'];
$route[] = ['/posts', 'PostController@index'];
$route[] = ['/posts/{id}/show', 'PostController@show'];


return $route;