<?php

namespace Oportunista\routes;

use Oportunista\entities\subject\SubjectDao;
use Oportunista\entities\users\User;
use Oportunista\ResponsePattern;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/subjects/course/{id}', function (Request $request, Response $response) {
    $requestUser = new User($request->getAttribute('user'));
    $courseId = $request->getAttribute('id');

    $subjectDao = new SubjectDao();
    $result = $subjectDao->findSubjectsByCourseId($courseId);

    if ($result == false) {
        $responsePattern = new ResponsePattern(false, 'No subjects for this course');
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