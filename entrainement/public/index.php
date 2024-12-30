<?php

// on recupère le chemin complet du dossier dans lequel on se trouve 

use App\Autoloader;
use entrainement\core\Main;

define('ROOT', dirname(__DIR__));

// on inclut notre autoloader
require_once ROOT . '/Autoloader.php';
Autoloader::register();

$start = new Main;
$start->start();
