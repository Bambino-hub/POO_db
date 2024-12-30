<?php

namespace App\Controllers;

abstract class controller
{
    // notre template par defaut

    public function render(string $fichier, array $donnees = [], $template = 'default.php')
    {

        // on extrait les données 
        extract($donnees);

        // on demarre un buffer de sortie
        ob_start();
        // a partir de ce point toute sortie est conservée en memooire


        // on envoie les information a m'a vue
        require_once ROOT . '/Views/' . $fichier;

        $contenu = ob_get_clean();

        require_once ROOT . '/Views/' . $template;
    }
}
