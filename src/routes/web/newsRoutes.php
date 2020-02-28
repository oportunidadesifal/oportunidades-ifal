<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/noticia/novo', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = 'Você não tem permissão para acessar esta página';
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    return $this->view->render($response, 'newsForm.twig', [
        'user' => $requestUser
    ]);
})->setName('newsForm')->add($sessionAuth);

$app->post('/noticia/store', function (Request $request, Response $response, $args) {
    //TODO FALTA IMPLEMENTAR
    //$result = $request->getParsedBody();
    var_dump($result);
    die;
})->setName('newsSave');