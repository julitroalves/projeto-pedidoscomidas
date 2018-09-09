<?php

declare(strict_types = 1);

require_once __DIR__ . '/../vendor/autoload.php';
// require_once __DIR__ . '/Application.php';


use PedidosComidas\Application;


error_reporting(E_ALL);

$whoops = new \Whoops\Run;

$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

$whoops->register();

Application::run();