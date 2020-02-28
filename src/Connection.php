<?php

namespace Oportunista;

use \PDO;

class Connection extends PDO
{
    public static function connect()
    {
        try {
            //localhost
            //$connect = new PDO("mysql:host=127.0.0.1;port=3306;dbname=oportunista", "root", "");
            //heroku
            $connect = new PDO("mysql:host=us-cdbr-iron-east-04.cleardb.net;port=3306;dbname=oportunista", "b45cc372dbb5ce", "943fe5a3");
            return $connect;
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
            die();
        }
    }
}
