<?php

namespace Oportunista;

use \PDO;
use PDOException;

class Connection extends PDO
{
    
    public static function connect()
    {
        try {
            //getConn: heroku =true, localhost=false
            require __DIR__ . '/settings.php';
            $ar = getConn(true);
            $dbnamehost = 'mysql:host=' . $ar['host'] . ';dbname=' . $ar['database'];
            $connect = new PDO($dbnamehost, $ar['username'], $ar['password']);

            return $connect;
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
            die();
        }
    }
}
