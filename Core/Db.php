<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{

    // Instance unique de la class
    private static $instance;

    // Information de connexion

    private const DBHOST = "localhost";
    private const DBNAME = "demo_poo";
    private const DBUSER = "root";
    private const DBPASS = "";

    private function __construct()
    {

        // DSN de connexion 
        $_dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME;

        // on appelle le constructeur de classe PDO

        try {
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('erreur :' . $e->getMessage());
        }
    }
    public static function getInstance(): Db
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
