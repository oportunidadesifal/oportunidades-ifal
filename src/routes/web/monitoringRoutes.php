<?php

use Oportunista\entities\opportunities\Monitoring;
use Oportunista\entities\opportunities\MonitoringDao;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


$app->get('/monitoria/novo', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = 'Você não tem permissão para acessar esta página';
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    return $this->view->render($response, 'monitoringForm.twig', [
        'user' => $requestUser
    ]);
})->setName('monitoringForm')->add($sessionAuth);

$app->post('/monitoria/store', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = 'Você não tem permissão para acessar esta página';
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $requestBody = $request->getParsedBody();

    $opportunity = new Monitoring($requestBody, 'Monitoring', $requestUserId);
    $opportunityDao = new MonitoringDao($opportunity);
    $result = $opportunityDao->save($opportunity);

    if ($result) {
        $_SESSION['success'] = 'Oportunidade inserida com sucesso.';
        return $response = $response->withRedirect($this->router->pathFor('addOpportunity'));
    }

    $_SESSION['error'] = 'Não foi possível processar a transação. Tente novamente.';

    return $response = $response->withRedirect($this->router->pathFor('addOpportunity'));
})->setName('monitoringSave')->add($sessionAuth);


