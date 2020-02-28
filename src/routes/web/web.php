<?php

namespace Oportunista\routes;

use Oportunista\entities\interests\Interest;
use Oportunista\entities\interests\InterestDao;
use Oportunista\entities\opportunities\OpportunityDao;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    return $this->view->render($response, 'home.twig');
})->setName('home');

$app->get('/oportunidade/novo', function (Request $request, Response $response) {
    $requestUser = $request->getAttribute('user');

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = 'Você não tem permissão para acessar esta página';
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $success = $_SESSION['success'] ?? false;
    $error = $_SESSION['error'] ?? false;
    unset($_SESSION['success']);
    unset($_SESSION['error']);

    return $this->view->render($response, 'addOpportunity.twig', [
        'user' => $requestUser,
        'success' => $success,
        'error' => $error
    ]);
})->setName('addOpportunity')->add($sessionAuth);

$app->get('/oportunidades[/[page[/[{page}]]]]', function (Request $request, Response $response) {
    $page = $request->getAttribute('page') ?? 0;
    $user = $request->getAttribute('user');
    $userId = $user['id'];
    $success = $_SESSION['success'] ?? false;
    $error = $_SESSION['error'] ?? false;
    unset($_SESSION['success']);
    unset($_SESSION['error']);

    $dao = new OpportunityDao;
    $result = $dao->getOpportunityPage($page);

    if ($result == false) {
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $interestDao = new InterestDao();

    if ($user['category'] === "Student") {
        foreach ($result as $opportunity) {
            $opportunity->setInterest($interestDao->checkInterests($userId, $opportunity->getId()));
        }
    }

    if ($user['category'] === "Teacher") {
        array_map(function($result) use ($userId, $interestDao) {
            $result->setInterest(
                $result->getAuthor()->getUserId() == $userId
                    ? $interestDao->getUsersInterestsByOpportunity($result->getId())
                    : false);
        }, $result);
    }

    return $this->view->render($response, 'indexOpportunity.twig', [
        'user' => $user,
        'opportunities' => $result,
        'page' => $page,
        'error' => $error,
        'success' => $success
    ]);
})->setName('indexOpportunity')->add($sessionAuth);

$app->get('/minhas-oportunidades', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');

    $dao = new OpportunityDao;
    $result = $dao->getOpportunityByUserId($user['id']);

    if ($result == false) {
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    return $this->view->render($response, 'userOpportunity.twig', [
        'user' => $user,
        'opportunities' => $result
    ]);
})->setName('userOpportunity')->add($sessionAuth);

$app->get('/oportunidades/visualizar/{id}', function (Request $request, Response $response) {
    $opportunityId = $request->getAttribute('id');
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    $dao = new OpportunityDao;
    $result = $dao->getOpportunityById($opportunityId);

    if (!$result) {
        return $this->view->render($response, 'opportunity.twig', [
            'user' => $requestUser,
            'opportunity' => $result
        ]);
    }

    $interestDao = new InterestDao();

    if ($requestUser['category'] === "Student") {
        $result->setInterest($interestDao->checkInterests($requestUserId, $result->getId()));
    }

    if ($requestUser['category'] === "Teacher") {
        $result->setInterest($result->getAuthorId() == $requestUserId
            ? $interestDao->getUsersInterestsByOpportunity($result->getId())
            : false);
    }

    return $this->view->render($response, 'opportunity.twig', [
        'user' => $requestUser,
        'opportunity' => $result
    ]);
})->setName('opportunityById')->add($sessionAuth);

$app->get('/oportunidades/editar/{id}', function (Request $request, Response $response) {
    $opportunityId = $request->getAttribute('id');
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = "Você não tem permissão para acessar esta página.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $dao = new OpportunityDao;
    $opportunity = $dao->getOpportunityById($opportunityId);

    if ($requestUserId != $opportunity->getAuthorId()) {
        $_SESSION['error'] = "Você não tem permissão para editar esta oportunidade.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    return $this->view->render($response, 'editForm.twig', [
        'user' => $requestUser,
        'opportunity' => $opportunity
    ]);

})->setName('editOpportunityById')->add($sessionAuth);

$app->post('/oportunidades/editar/{id}', function (Request $request, Response $response) {
    $opportunityId = $request->getAttribute('id');
    $requestUser = $request->getAttribute('user');
    $requestUserId = $requestUser['id'];
    $body = $request->getParsedBody();

    if ($requestUser['category'] != 'Teacher') {
        $_SESSION['error'] = "Você não tem permissão para acessar esta página.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $dao = new OpportunityDao;
    $opportunity = $dao->getOpportunityById($opportunityId);

    if ($requestUserId != $opportunity->getAuthorId()) {
        $_SESSION['error'] = "Você não tem permissão para editar esta oportunidade.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $opportunityType = htmlspecialchars($body['type']);
    $opportunityType = ucfirst(strtolower($opportunityType));
    $path = 'Oportunista\entities\opportunities\\'.$opportunityType;
    $pathDao = 'Oportunista\entities\opportunities\\'.$opportunityType.'Dao';

    $opportunity = new $path($body, $opportunityType, $requestUserId, $opportunityId);
    $opportunityDao = new $pathDao($opportunity);
    $result = $opportunityDao->update($opportunity);

    if ($result == true) {
        $_SESSION['success'] = 'Oportunidade editada com sucesso.';
        return $response = $response->withRedirect($this->router->pathFor('addOpportunity'));
    }

    $_SESSION['error'] = 'Não foi possível processar a transação. Tente novamente.';
    return $response = $response->withRedirect($this->router->pathFor('addOpportunity'));

})->setName('editOpportunitySave')->add($sessionAuth);

$app->get('/meus-interesses', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $userId = $user['id'];

    if ($user['category'] == 'Teacher') {
        $_SESSION['error'] = "Você não tem permissão para acessar esta página.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $interestsDao = new InterestDao;
    $result = $interestsDao->getInterests($userId);

    if($result == false) {
        $_SESSION['error'] = "Você não possui interesses.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $opportunityDao = new OpportunityDao();
    foreach ($result as $opportunity) {
        $opp = $opportunityDao->getOpportunityById($opportunity->opportunityId);
        if ($opp) {
            $opportunities[] = $opp;
        }
    }

    return $this->view->render($response, 'userOpportunitiesInterests.twig', [
        'user' => $user,
        'opportunities' => $opportunities
    ]);
})->setName('userInterests')->add($sessionAuth);

$app->post('/interesse/{id}', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $userId = $user['id'];
    $id = $request->getAttribute('id');

    if ($user['category'] == 'Teacher') {
        $_SESSION['error'] = "Você não tem permissão para acessar esta página.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    $opportunityDao = new OpportunityDao;
    $opportunity = $opportunityDao->getOpportunityById($id);
    $opportunity->setInterest(true);

    if (!$opportunity) {
        $_SESSION['error'] = "Essa oportunidade não existe.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    //Create interest object
    $interests = new Interest($opportunity, $userId);

    //Create interestsDao and insert interests
    $interestsDao = new InterestDao();
    $result = $interestsDao->insertInterests($interests);

    if ($result === true) {
        $_SESSION['success'] = "Você demonstrou interesse nessa oportunidade.";
    }
    $router = $this->router;
    return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
})->setName('saveInterest')->add($sessionAuth);

$app->post('/remove-interesse/{id}', function (Request $request, Response $response) {
    $user = $request->getAttribute('user');
    $userId = $user['id'];

    if ($user['category'] == 'Teacher') {
        $_SESSION['error'] = "Você não tem permissão para acessar esta página.";
        $router = $this->router;
        return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
    }

    //Get Opportunity id from request
    $opportunityId = $request->getAttribute('id');

    //Create interestsDao and insert interests
    $interestsDao = new InterestDao();
    $result = $interestsDao->deleteInterests($opportunityId, $userId);

    if ($result === true) {
        $_SESSION['success'] = "Você retirou seu interesse nessa oportunidade.";
    }

    $router = $this->router;
    return $response = $response->withRedirect($router->pathFor('indexOpportunity'));
})->setName('deleteInterest')->add($sessionAuth);






