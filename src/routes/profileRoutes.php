<?php

namespace Oportunista\routes;

use Oportunista\entities\users\UserDao;
use Oportunista\ResponsePattern;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Oportunista\JWT;
use Oportunista\entities\users\User;

$app->post('/api/api/profile', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');
    $requestUser = new User($requestUser);

    $body = $request->getBody();
    $body = json_decode($body, true);

    $category = $requestUser->getCategory();
    $path = 'Oportunista\entities\users\\'.$category;
    $pathDao = 'Oportunista\entities\users\\'.$category.'Dao';

    $profile = new $path($body, $requestUser);
    $profileDao = new $pathDao($profile);
    $result = $profileDao->save();

    if ($result === true) {
        $responsePattern = new ResponsePattern(false);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 201);
    }

    $responsePattern = new ResponsePattern(false, $result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 400);
})->add($auth);

$app->get('/api/api/profile/{id}', function (Request $request, Response $response) {
    $userId = $request->getAttribute('id');
    $user = UserDao::find($userId);

    if (!$user) {
        $responsePattern = new ResponsePattern(false, 'Invalid User Id');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 404);
    }

    $category = $user->getCategory();
    $pathDao = 'Oportunista\entities\users\\'.$category.'Dao';
    $profileDao = new $pathDao();
    $profile = $profileDao->find($user);

    $responsePattern = new ResponsePattern($profile);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
});


