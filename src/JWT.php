<?php

namespace Oportunista;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Oportunista\Connection;
use Oportunista\entities\users\User;
use \PDO;

class JWT
{

    private $token;
    private $key = 'lksdfnjlshdfaohdf9384iejfseuyf0wuerfkj';
    
    public function getToken(User $user)
    {
        $signer = new Sha256();

        $this->token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
        ->setAudience('http://example.org') // Configures the audience (aud claim)
        ->setId(uniqid('', true), true) // Configures the id (jti claim), replicating as a header item
        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
        ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
        ->setExpiration(time() + 864000) // Configures the expiration time of the token (exp claim)
        ->set('uid', $user->getId())
        ->set('uname', $user->getUsername()) // Configures a new claim, called "uid"
        ->set('ucategory', $user->getCategory())
        ->sign($signer, $this->key) // creates a signature using "testing" as key
        ->getToken(); // Retrieves the generated token

        return $this->token;
    }

    public function validationToken($token)
    {
        $signer = new Sha256();
        $token = (new Parser())->parse($token);
    
        if (!$token->verify($signer, $this->key)) {
            return false;
        }

        if ($this->isOnBlackList($token)) {
            return false;
        }

        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer('http://example.com');
        $data->setAudience('http://example.org');
        $data->setCurrentTime(time());

        if ($token->validate($data)) {
            $user = array();
            $user['id'] = $token->getClaim('uid');
            $user['username'] = $token->getClaim('uname');
            $user['category'] = $token->getClaim('ucategory');
            $user['expToken'] = $token->getClaim('exp');
            $user['jti'] = $token->getClaim('jti');
            return $user;
        } else {
            return false;
        }
    }
    
    public function addToBlackList($token)
    {
        
        $sql = "INSERT INTO jwtBlackList (jwtId, expTime) values(:jwtId, FROM_UNIXTIME(:expTime))";
        
        $con = Connection::connect();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':jwtId', $token['jti']);
        $stmt->bindValue(':expTime', $token['expToken']);
        
        return $stmt->execute();
    }

    public function isOnBlackList($token)
    {
        $sql = "SELECT * FROM jwtBlackList where jwtId = :jwtId";
        $con = Connection::connect();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':jwtId', $token->getClaim('jti'));
        $stmt->execute();
        $row = $stmt->rowCount();

        if ($row == 0) {
            return false;
        }

        return true;
    }
}
