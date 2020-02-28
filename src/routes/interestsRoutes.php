<?php

namespace Oportunista\routes;

use Oportunista\ResponsePattern;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Oportunista\entities\users\UserDao;
use Oportunista\entities\opportunities\OpportunityDao;
use Oportunista\entities\interests\InterestDao;
use Oportunista\entities\interests\Interest;

$app->post('/api/interests/{id}', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $userId = $user['id'];

    if ($user['category'] != 'Student') {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 403);
    }

    //Get id from request
    $id = $request->getAttribute('id');
    
    //Get Opportunity Data
    $opportunityDao = new OpportunityDao;
    $opportunity = $opportunityDao->getOpportunityById($id);
    $opportunity->setInterest(true);

    if (!$opportunity) {
        $responsePattern = new ResponsePattern(false, 'This opportunity does not exist.');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 200);
    }
    
    //Create interest object
    $interests = new Interest($opportunity, $userId);

    //Create interestsDao and insert interests
    $interestsDao = new InterestDao();
    $result = $interestsDao->insertInterests($interests);

    if ($result === true) {
        $responsePattern = new ResponsePattern(false, false);
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

$app->delete('/api/interests/{id}', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $userId = $user['id'];

    if ($user['category'] != 'Student') {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 403);
    }

    //Get Opportunity id from request
    $opportunityId = $request->getAttribute('id');

    //Create interestsDao and insert interests
    $interestsDao = new InterestDao();
    $result = $interestsDao->deleteInterests($opportunityId, $userId);

    if ($result === true) {
        $responsePattern = new ResponsePattern(false, false);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 204);
    }

    $responsePattern = new ResponsePattern(false, $result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
    ->withHeader('Content-type', 'application/json')
    ->withJson($responsePattern, 400);
})->add($auth);

//Get current User Interest.
$app->get('/api/interests/users/', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $userId = $user['id'];

    if ($user['category'] != 'Student') {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 403);
    }

    $interestsDao = new InterestDao;
    $result = $interestsDao->getInterests($userId);

    if ($result) {
        $responsePattern = new ResponsePattern($result);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
    }

    $responsePattern = new ResponsePattern(false, 'You do not have any interests.');
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
    ->withHeader('Content-type', 'application/json')
    ->withJson($responsePattern, 200);
})->add($auth);

//Get Interested Users profile by opportunity id
$app->get('/api/interests/opportunities/{id}', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $opportunityId = $request->getAttribute('id');
    $userId = $user['id'];

    if ($user['category'] != 'Teacher') {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 403);
    }

    $opportunityDao = new OpportunityDao();
    $result = $opportunityDao->getOpportunityById($opportunityId);
    $authorId = $result->getAuthorId();

    if ($userId != $authorId) {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 403);
    }

    $interestsDao = new InterestDao();
    $result = $interestsDao->getUsersInterestsByOpportunity($opportunityId);

    if ($result) {
        $responsePattern = new ResponsePattern($result);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
    }

    $responsePattern = new ResponsePattern(false, 'No interests for this opportunity');
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
    ->withHeader('Content-type', 'application/json')
    ->withJson($responsePattern, 200);
})->add($auth);
