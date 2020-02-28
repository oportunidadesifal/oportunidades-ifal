<?php

namespace Oportunista\routes;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$container['db'];

//Api Routes
require __DIR__ . '/routes/usersRoutes.php';
require __DIR__ . '/routes/opportunitiesRoutes.php';
require __DIR__ . '/routes/interestsRoutes.php';
require __DIR__ . '/routes/tagsRoutes.php';
require __DIR__ . '/routes/profileRoutes.php';
require __DIR__ . '/routes/newsRoutes.php';
require __DIR__ . '/routes/subjectRoutes.php';
require __DIR__ . '/routes/userDeviceTokenRoutes.php';

//Web Routes
require __DIR__ . '/routes/web/web.php';
require __DIR__ . '/routes/web/loginRoutes.php';
require __DIR__ . '/routes/web/newsRoutes.php';
require __DIR__ . '/routes/web/researchRoutes.php';
require __DIR__ . '/routes/web/eventRoutes.php';
require __DIR__ . '/routes/web/jobRoutes.php';
require __DIR__ . '/routes/web/monitoringRoutes.php';
require __DIR__ . '/routes/web/signUpRoutes.php';

$app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});