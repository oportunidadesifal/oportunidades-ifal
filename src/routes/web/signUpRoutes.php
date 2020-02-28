<?php

namespace Oportunista\routes;

use Oportunista\entities\users\User;
use Oportunista\entities\users\UserDao;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/signup', function (Request $request, Response $response) {
    $error = $_SESSION['error'] ?? false;
    unset($_SESSION['error']);

    return $this->view->render($response, 'signup.twig', [
        'error' => $error
    ]);
})->setName('signUpForm');

$app->post('/signup/store', function (Request $request, Response $response) {
    $requestBody = $request->getParsedBody();

    $user = new User($requestBody);
    $userDao = new UserDao($user);
    $result = $userDao->save();

    if ($result != true) {
        $_SESSION['error'] = 'Não foi possível processar a transação. Tente novamente.';
        return $response = $response->withRedirect($this->router->pathFor('signUpForm'));
    }

    $user = $userDao->checkUser();
    $category = $user->getCategory();
    $path = 'Oportunista\entities\users\\'.$category;
    $pathDao = 'Oportunista\entities\users\\'.$category.'Dao';

    $profile = new $path($requestBody, $user);
    $profileDao = new $pathDao($profile);
    $result = $profileDao->save();

    if($result != true) {
        $_SESSION['error'] = 'Não foi possível processar a transação. Tente novamente.';
        return $response = $response->withRedirect($this->router->pathFor('signUpForm'));
    }

    $_SESSION['success'] = 'Usuário criado com sucesso.';
    return $response = $response->withRedirect($this->router->pathFor('login'));

})->setName('signUpAction');