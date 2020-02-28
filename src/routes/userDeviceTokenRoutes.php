<?php

namespace Oportunista\routes;

use Oportunista\entities\UserDeviceToken\UserDeviceToken;
use Oportunista\entities\users\User;
use Oportunista\ResponsePattern;
use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/api/push', function (Request $request, Response $response) {
    $requestUser = new User($request->getAttribute('user'));

    $body = $request->getBody();
    $body = json_decode($body, true);

    $userDevice = new UserDeviceToken();
    $userDevice->user_id = $requestUser->getId();
    $userDevice->deviceToken = $body['token'];

    if ($userDevice->save()) {
        $responsePattern = new ResponsePattern(false);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern,201);
    }

    $responsePattern = new ResponsePattern(false, 'Could not process the transaction.');
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 400);
})->add($auth);

$app->delete('/api/push', function (Request $request, Response $response) {
    $body = $request->getBody();
    $body = json_decode($body, true);

    $userDevice = UserDeviceToken::where('deviceToken', $body['token']);
    $result = $userDevice->delete();

    if ($result > 0) {
        $responsePattern = new ResponsePattern(false);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 204);
    }

    $responsePattern = new ResponsePattern(false. 'Coult not process the transaction.');
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 403);
})->add($auth);

