<?php

namespace Oportunista\routes;

use Oportunista\entities\news\News;
use Oportunista\entities\news\NewsDao;
use Oportunista\entities\users\User;
use Oportunista\entities\users\UserDao;
use Oportunista\ResponsePattern;
use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/api/news', function (Request $request, Response $response) {
    $requestUser = new User($request->getAttribute('user'));

    if ($requestUser->getCategory() != 'Teacher') {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 405);
    }

    $body = $request->getBody();
    $decode = json_decode($body);

    $news = new News($decode, $requestUser);
    $newsDao = new NewsDao($news);
    $result = $newsDao->save();

    if ($result == false) {
        $responsePattern = new ResponsePattern(false, $result);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 405);
    }

    $responsePattern = new ResponsePattern(false);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
})->add($auth);
