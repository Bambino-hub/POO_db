<?php

namespace entrainement\core;

use App\Controllers\MainController;

class Main
{

    public function start()
    {

        // recupère uri de notre site 
        $uri = $_SERVER['REQUEST_URI'];

        // on verifie si l'uri n'est pas vide et se termine par un /
        if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {
            // on enlève le slash
            $uri = substr($uri, 0, -1);

            // on envoie un code de redirection permanente
            http_response_code(301);

            // on fait la redirection de vers l'uri sans /
            header('Location :' . $uri);
        }

        // maintenant on separe les parametres dans un tableau
        $param = explode('/', $_GET['p']);

        // on verifie si on a au moins un parametre on le rcupère et on met en majuscule la première lettre
        // et on donne son namespace complet et concatene avec Controller
        if ($param[0] != '') {
            $controller = 'App\\Controllers\\' . ucfirst(array_shift($param)) . 'Controller';

            // on instancie le contrôlleur
            $controller = new $controller();

            // on recupère le deuxieme paramètre qui est l'action
            $action = isset($param[0]) ? array_shift($param) : 'index';

            if (method_exists($controller, $action)) {

                // s'il reste encore des paramètre on la passe a la methode
                isset($param[0]) ? call_user_func_array([$controller, $action], $param) : $controller->$action;
            } else {
                http_response_code(404);
                echo 'la page demandée n\'esxiste pas';
            }
        } else {
            // si on a pas de parametre oninstancie le controller par defaut
            $controller = new MainController();
            $controller->index();
        }
    }
}
