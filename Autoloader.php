<?php

namespace App;

class Autoloader
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__, "autoload"));
    }

    static function autoload($class)
    {
        // on recupere dans la classe la totalité du namespace 
        // exemple (App\client\Compte)
        //on retire App\ de notre namespace et on aura client\Conpte
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);

        // on remplace les \ par des /
        $class = str_replace('\\', '/', $class);
        $file = __DIR__ . '/' . $class . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
}
