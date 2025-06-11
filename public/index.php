<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;


$router = new Router();
$router->add('GET', '/musicas', 'MusicaController@index');
$router->add('GET', '/musicas/{id}', 'MusicaController@view');
$router->add('POST', '/musicas', 'MusicaController@add');
$router->add('PUT', '/musicas/{id}', 'MusicaController@edit');
$router->add('DELETE', '/musicas/{id}', 'MusicaController@delete');
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);