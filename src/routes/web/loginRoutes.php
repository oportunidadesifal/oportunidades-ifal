<?php

namespace Oportunista\routes;

use Oportunista\entities\users\User;
use Oportunista\entities\users\UserDao;
use Oportunista\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/login', function (Request $request, Response $response) {
    if (isset($_SESSION['userToken'])) {
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('addOpportunity'));
    }

    $success = $_SESSION['success'] ?? false;
    $error = $_SESSION['error'] ?? false;
    unset($_SESSION['success']);
    unset($_SESSION['error']);

    return $this->view->render($response, 'login.twig', [
        'success' => $success,
        'error' => $error
    ]);
})->setName('login');

$app->post('/signin', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $user = new User($data);
    $userLogin = new UserDao($user);
    $validUser = $userLogin->checkUser();

    $router = $this->router;

    if ($validUser) {
        $jwt = new JWT();
        $_SESSION['userToken'] = $jwt->getToken($validUser)->__toString();
        return $response = $response->withRedirect($router->pathFor('addOpportunity'));
    }
    $_SESSION['error'] = 'Usuário ou senha inválidos.';
    return $response = $response->withRedirect($router->pathFor('login'));

})->setName('loginAction');


$app->map(['GET', 'POST'], '/signout', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $jwt = new JWT();
    $result = $jwt->addToBlackList($user);
    session_destroy();

    $router = $this->router;
    return $response = $response->withRedirect($router->pathFor('home'));

})->setName('logoutAction')->add($sessionAuth);