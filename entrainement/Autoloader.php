<?php

namespace entrainement;

class Autoloader
{

    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'Autoload'));
    }
    public static function autoload($class)
    { // on recupere la classe avec la totalité du namespace
        // on remplace App\ par du vide 
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);

        // on remplace les \ par les /
        $class = str_replace('\\', '/', $class);
        $file = __DIR__ . '/' . $class . '.php';

        // on verife  si le fichier  existe si oui on l'inclu
        if (file_exists($file)) {
            require $file;
        }
    }
}
