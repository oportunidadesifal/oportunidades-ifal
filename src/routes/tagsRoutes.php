<?php

namespace Oportunista\routes;

use Oportunista\entities\tags\TagDao;
use Oportunista\ResponsePattern;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/api/tags', function (Request $request, Response $response) {
    $dao = new TagDao();
    $result = $dao->get();

    if (!$result) {
        $responsePattern = new ResponsePattern(false, 'Could not process the transaction.');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 404);
    }

    $responsePattern = new ResponsePattern($result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
})->add($auth);