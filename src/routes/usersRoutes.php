<?php

namespace Oportunista\routes;

use Oportunista\entities\users\UserDao;
use Oportunista\ResponsePattern;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Oportunista\JWT;
use Oportunista\entities\users\User;

$app->post('/api/login', function (Request $request, Response $response) {
    
    $requestBody = $request->getBody();
    $requestBody = json_decode($requestBody, true);

    $user = new User($requestBody);
    $userLogin = new UserDao($user);
    $validUser = $userLogin->checkUser();
    
    if ($validUser) {
        $jwt = new JWT();
        $token = $jwt->getToken($validUser);
        $data = [
                'token' => "$token"
        ];

        $responsePattern = new ResponsePattern($data);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response->withHeader('Content-type', 'application/json')->withJson($responsePattern, 200);
    }

    $responsePattern = new ResponsePattern(false,'Invalid username or invalid password.');
    $responsePattern = $responsePattern->getResponse();
    
    return $response = $response->withHeader('Content-type', 'application/json')->withJson($responsePattern, 401);
})->add($hasAuthHeader);

$app->map(['GET', 'POST'], '/renew', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $user = new User($user);

    $jwt = new JWT();
    $token = $jwt->getToken($user);
    $data = [
        'token' => "$token",
    ];

    $responsePattern = new ResponsePattern($data);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response->withHeader('Content-type', 'application/json')->withJson($responsePattern, 200);
})->add($auth);

$app->map(['GET', 'POST'], '/logout', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $jwt = new JWT();
    $result = $jwt->addToBlackList($user);

    if ($result) {
        $responsePattern = new ResponsePattern(false);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response->withHeader('Content-type', 'application/json')->withJson($responsePattern, 200);
    }

    $responsePattern = new ResponsePattern(false,'Could not process the transaction');
    $responsePattern = $responsePattern->getResponse();

    return $response = $response->withHeader('Content-type', 'application/json')->withJson($responsePattern, 200);
})->add($auth);

//Cria usuario
$app->post('/api/users', function (Request $request, Response $response) {
      
    $body = $request->getBody();
    $body = json_decode($body, true);

    $user = new User($body);
    $userDao = new UserDao($user);
    $result = $userDao->save();

    if ($result === true) {

        $user = $userDao->checkUser();
        $jwt = new JWT();
        $token = $jwt->getToken($user);
        $data = [
            'token' => "$token"
        ];

        $responsePattern = new ResponsePattern($data);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->witdhJson($responsePattern, 201);
    }

    $responsePattern = new ResponsePattern(false, $result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 400);
})->add($hasAuthHeader);
