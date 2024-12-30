<?php

namespace App\Public;
// on definie une constante contenant le dossier racine du projet 

// comme on est pas dans une classe on utilise "difine pour definir nos constantes

use App\Autoloader;
use App\Core\Main;


define('ROOT', dirname(__DIR__));
// la fonction dirname nous donne le chemin du dossier dans lequel on se trouve 

// on importe  l'autoloader
require_once ROOT . '/Autoloader.php';
Autoloader::register();

// on instancie la classe Main(notre routuer)
$app = new Main();

$app->start();
