<?php

namespace Oportunista;

use Oportunista\entities\users\User;

$auth = function ($request, $response, $next) {
    if (!$request->hasHeader('Authorization')) {
        $responsePattern = new ResponsePattern(false, 'You must send a Authorization Header');
        $responsePattern = $responsePattern->getResponse();

        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson($responsePattern, 401);
    }

    $token = $request->getHeader('Authorization');
    list($token) = sscanf($token[0], "Bearer %s");
    $jwt = new JWT();
    $user = $jwt->validationToken($token);
        
    if ($user) {
        $request = $request->withAttribute('user', $user);
        return $response = $next($request, $response);
    }

    $responsePattern = new ResponsePattern(false, 'Invalid credentials');
    $responsePattern = $responsePattern->getResponse();

    return $response = $response
        ->withHeader('Content-type', 'application/json')
        ->withJson($responsePattern, 401);
};

$hasAuthHeader = function ($request, $response, $next) {
    if ($request->hasHeader('Authorization')) {
        return $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withJson([
                'Error' => 'You must logout before login'], 400);
    }

    return $response = $next($request, $response);
};

$sessionAuth = function ($request, $response, $next) {
    if (isset($_SESSION['userToken'])) {
        $token = $_SESSION['userToken'];
        $jwt = new JWT();
        $user = $jwt->validationToken($token);
    }

    if ($user) {
        $userObject = new User($user);
        $category = $user['category'];
        $pathDao = 'Oportunista\entities\users\\'.$category.'Dao';
        $profileDao = new $pathDao;
        $user['profile'] = $profileDao->find($userObject);

        $request = $request->withAttribute('user', $user);
        return $response = $next($request, $response);
    }

    return $response = $response->withRedirect('/login', 403);

};

$cors = function ($request, $response, $next) {
    $response = $next($request, $response);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
};

$app->add($cors);