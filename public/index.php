<?php
session_start();
require_once(__DIR__."/../vendor/autoload.php");

$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

//Set up dependencies
require __DIR__ . '/../src/dependencies.php';

//Middleware
require __DIR__ . '/../src/middleware.php';

//Routes
require __DIR__ . '/../src/routes.php';

$app->run();
