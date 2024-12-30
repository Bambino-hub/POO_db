<?php

namespace entrainement\core;

use PDO;
use PDOException;

class Db extends PDO
{
    // on cree une instance unique a la base de donnees
    private static $intance;

    // les information sur le DNS  de connexion
    private const DBHOST = 'localhost';
    private const DBNAME = 'demo_poo';
    private const DBUSER = 'root';
    private const DBPASS = '';

    private function __construct()
    {
        // creation de notre dsn
        $dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME;

        // on envoie les information sur le constructeur de la classe pdo
        try {
            parent::__construct($dsn, self::DBUSER, self::DBPASS);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('erreur :' . $e->getMessage());
        }
    }
    public static function getInstance(): Db
    {
        if (self::$intance === null) {
            self::$intance = new self();
        }
        return self::$intance;
    }
}
