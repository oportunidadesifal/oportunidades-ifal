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
            
            $ar = require __DIR__ . '/settings.php';
            $dbnamehost = 'mysql:host=' . $ar['settings']['db']['host'] . ';dbname=' . $ar['settings']['db']['database'];
            $connect = new PDO($dbnamehost, $ar['settings']['db']['username'], $ar['settings']['db']['password']);

            return $connect;
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
            die();
        }
    }
}
