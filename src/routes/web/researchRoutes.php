<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/pesquisa/novo', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = 'Você não tem permissão para acessar esta página';
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    return $this->view->render($response, 'researchForm.twig', [
        'user' => $requestUser
    ]);
})->setName('researchForm')->add($sessionAuth);

$app->post('/pesquisa/store', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = 'Você não tem permissão para acessar esta página';
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $requestBody = $request->getParsedBody();

    $opportunity = new \Oportunista\entities\opportunities\Research($requestBody, 'Research', $requestUserId);
    $opportunityDao = new \Oportunista\entities\opportunities\ResearchDao($opportunity);
    $result = $opportunityDao->save($opportunity);

    if ($result) {
        $_SESSION['success'] = 'Oportunidade inserida com sucesso.';
        return $response = $response->withRedirect($this->router->pathFor('addOpportunity'));
    }

    $_SESSION['error'] = 'Não foi possível processar a transação. Tente novamente.';

    return $response = $response->withRedirect($this->router->pathFor('addOpportunity'));
})->setName('researchSave')->add($sessionAuth);