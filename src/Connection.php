<?php

namespace Oportunista;

use \PDO;

class Connection extends PDO
{
    public static function connect()
    {
        try {
            $connect = new PDO("mysql:host=127.0.0.1;port=3306;dbname=oportunista", "root", "");
            return $connect;
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
            die();
        }
    }
}
