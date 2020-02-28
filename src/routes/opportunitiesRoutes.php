<?php

namespace Oportunista\routes;

use Oportunista\entities\interests\InterestDao;
use Oportunista\Resources\Notification\EmailNotification;
use Oportunista\Resources\Notification\Message;
use Oportunista\Resources\Notification\NotificationSender;
use Oportunista\Resources\Notification\PushNotification;
use Oportunista\ResponsePattern;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Oportunista\entities\users\UserDao;
use Oportunista\entities\opportunities\OpportunityDao;
use Oportunista\entities\opportunities\Opportunity;
use Oportunista\JWT;

// Cadastra opportunity Identificando pelo Tipo (type)
$app->post('/opportunities', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');
    $userId = $requestUser['id'];

    if ($requestUser['category'] != 'Teacher') {

        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 405);
    }

    $body = $request->getBody();
    $decode = json_decode($body, true);

    //Proteção contra XSS e padronizando formato do tipo
    $opportunityType = htmlspecialchars($decode['type']);
    $opportunityType = ucfirst(strtolower($opportunityType));
    $path = 'Oportunista\entities\opportunities\\'.$opportunityType;
    $pathDao = 'Oportunista\entities\opportunities\\'.$opportunityType.'Dao';

    $opportunity = new $path($decode, $opportunityType, $userId);
    $opportunityDao = new $pathDao($opportunity);
    $result = $opportunityDao->save($opportunity);

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

$app->get('/opportunities', function (Request $request, Response $response) {
    $dao = new OpportunityDao;
    $result = $dao->getAll();
    if ($result) {
        $responsePattern = new ResponsePattern($result);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
    }
})->add($auth);

$app->get('/opportunities/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    $dao = new OpportunityDao;
    $result = $dao->getOpportunityById($id);

    $interestDao = new InterestDao();

    if (!$result) {

        $responsePattern = new ResponsePattern(false, 'This opportunity does not exist.');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 200);
    }

    if ($requestUser['category'] === "Student") {
        $result->setInterest($interestDao->checkInterests($requestUserId, $result->getId()));
    }

    if ($requestUser['category'] === "Teacher") {
        $result->setInterest($result->getAuthorId() == $requestUserId
            ? $interestDao->getUsersInterestsByOpportunity($result->getId())
            : false);
    }

    $responsePattern = new ResponsePattern($result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);

})->add($auth);

$app->get('/api/opportunities/users/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    $opportunityDao = new OpportunityDao;
    $result = $opportunityDao->getOpportunityByUserId($id);

    if (!$result) {
        $responsePattern = new ResponsePattern(false,  'No opportunities for this id.');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 200);
    }

    if ($id == $requestUserId) {
        $interestsDao = new InterestDao();
        foreach ($result as $opportunity) {
            $opportunity->interest = $interestsDao->getUsersInterestsByOpportunity($opportunity->id);
        }
    }

    $responsePattern = new ResponsePattern($result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
})->add($auth); //Sem campo deleted e Retorna somente os ativos

$app->get('/api/opportunities/users/{id}/trash', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    if ($id != $requestUserId) {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 405);
    }

    $dao = new OpportunityDao;
    $result = $dao->getOpportunityByUserIdTrash($id);

    if (!$result) {
        $responsePattern = new ResponsePattern(false, 'No opportunities for this id.');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 200);
    }

    $responsePattern = new ResponsePattern($result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
})->add($auth);  //Retorna os deletados de determinado usuário.

$app->get('/api/opportunities/page/{num}', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    $num = $request->getAttribute('num');
    $dao = new OpportunityDao;
    $result = $dao->getOpportunityPage($num);

    $interestDao = new InterestDao();

    if (!$result) {
        $responsePattern = new ResponsePattern(false, 'No opportunities.');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 200);
    }

    if ($requestUser['category'] === "Student") {
        foreach ($result as $opportunity) {
            $opportunity->setInterest($interestDao->checkInterests($requestUserId, $opportunity->getId()));
        }
    }

    if ($requestUser['category'] === "Teacher") {
        array_map(function($result) use ($requestUserId, $interestDao) {
            $result->setInterest(
                $result->getAuthor()->getUserId() == $requestUserId
                ? $interestDao->getUsersInterestsByOpportunity($result->getId())
                : false);
        }, $result);
    }

    $responsePattern = new ResponsePattern($result);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);
})->add($auth);

$app->put('/api/opportunities/{id}', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');
    $userId = $requestUser['id'];
    $opportunityId = $request->getAttribute('id');
    $body = $request->getBody();
    $decode = json_decode($body, true);

    if ($requestUser['category'] != 'Teacher') {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 405);
    }

    $opportunity = new OpportunityDao();
    $opportunity = $opportunity->getOpportunityById($opportunityId);

    if ($userId != $opportunity->getAuthorId()) {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 405);
    }

    $opportunityType = htmlspecialchars($decode['type']);
    $opportunityType = ucfirst(strtolower($opportunityType));
    $path = 'Oportunista\entities\opportunities\\'.$opportunityType;
    $pathDao = 'Oportunista\entities\opportunities\\'.$opportunityType.'Dao';

    $opportunity = new $path($decode, $opportunityType, $userId, $opportunityId);
    $opportunityDao = new $pathDao($opportunity);
    $result = $opportunityDao->update($opportunity);

    if ($result !== true) {
        $responsePattern = new ResponsePattern(false, $result);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 400);
    }

    $message = 'A oportunidade '. $opportunity->getTitle() . 'foi alterada. Confira já!';
    $subject = 'Atualização!';
    $message = new Message($message, $subject);

    $interestedUsers = new InterestDao();
    $interestedUsers = $interestedUsers->getUsersInterestsByOpportunity($opportunityId);

    $email = new EmailNotification($message, $interestedUsers);
    $push = new PushNotification($message, $interestedUsers);

    $sender = new NotificationSender();
    $sender->add($email);
    $sender->add($push);
    $sender->send();

    $responsePattern = new ResponsePattern(false, false);
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 200);

})->add($auth);

$app->delete('/api/opportunities/{id}', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');
    $userId = $requestUser['id'];

    if ($requestUser['category'] != 'Teacher') {
        $responsePattern = new ResponsePattern(false, 'You do not have permissions');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 405);
    }

    $id = $request->getAttribute('id');
    $dao = new OpportunityDao;
    $result = $dao->deleteOpportunity($id, $userId);

    if ($result) {
        $responsePattern = new ResponsePattern(false, false);
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 204);
    }

    $responsePattern = new ResponsePattern(false, 'Could not process the transaction.');
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
    ->withHeader('Content-type', 'application/json')
    ->withJson($responsePattern, 403);

})->add($auth);
