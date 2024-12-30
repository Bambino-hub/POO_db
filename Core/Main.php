<?php

namespace App\Core;

use App\Controllers\MainController;

class Main
{
    /**
     * conttrroller principal
     *
     * @return void
     */
    public function start()
    {
        // demarre la session
        session_start();

        /*
           nos url seront sous lla forme : http://poo_db.test/controlleur/methodes/parametres
           exemple : http://poo_db.test/annonces/details/brouette (c'est ce que verra le visiteur)
           on va reercrire ça en : http://poo_db.test/index.php?p=annonces/details/brouette
         on va reecrire nos url
        */

        // recupère le "traling slash" éventuel de l'URL
        // on recupere l'url
        $uri = $_SERVER['REQUEST_URI'];

        // On verifie que uri n'est pas vide et se termine par un /
        if (!empty($uri) && $uri !== '/' && $uri[-1] === "/") {
            // on enlève le slash /
            $uri = substr($uri, 0, -1);

            // on envoie un code de ridirection permanente
            http_response_code(301);

            // redirige vers l'url sans /
            header('Location:' . $uri);
        }

        // on gère les parametres d'url
        // p=controlleur/methodes/parametres
        // on separe les parametre dans un tableau
        $param = explode('/', $_GET['p']) ?? 'main/index';
        // var_dump($param);
        //on verifie si on au moins 1 parametre
        if ($param[0] != '') {
            // on recupere le nom de controller à instacier
            // on ajoute une majuscule en première lettre, on ajoute le namespace complet avant et on ajoute "Controller" après
            // array_shift permet de recuperer le premier element d'un tableau
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($param)) . 'Controller';
            //on instancie le contrôleur
            $controller = new $controller();

            // on repere le deuxieme parametre de l'url
            $action = (isset($param[0])) ? array_shift($param) : 'index';
            if (method_exists($controller, $action)) {
                // s'il reste des paramètre on les passe a la methode
                (isset($param[0])) ? call_user_func_array([$controller, $action], $param) : $controller->$action();
            } else {
                http_response_code(404);
                echo "La page rechercher n'existe pas";
            }
            // var_dump($controller);
            // die;
        } else {
            // si on a pas de parametre,
            // on instancie le controlleur par defaut
            $controller = new MainController();
            $controller->index();
        }
    }
}
