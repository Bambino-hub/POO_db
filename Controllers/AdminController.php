<?php

namespace App\Controllers;

use App\Models\AnnonceModel;

class AdminController extends Controller
{
    public function index()
    {

        // on verilfie si on est admin
        if ($this->isAdmin()) {
            $this->render('admin/index.php');
        }
    }

    /**
     * fonction qui verifie si l'utilisateur connectée est unadministratuer
     *
     * @return boolean
     */
    private function isAdmin()
    {
        // on verifie si on est connecté et si ROLE_ADMIN est dans nos roles
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
            // on est admin
            return true;
        } else {
            // si on est pas admin
            $_SESSION['erreur'] = "vous n'avez pas accès a cette zon";
            header('Location: index.php?p=annonce/index');
            exit();
        }
    }

    /**
     * afficher les annonces sous frome d'un tableau
     *
     * @return void
     */
    public function annonce()
    {
        if ($this->isAdmin()) {
            $annonce = new AnnonceModel();

            $annonces = $annonce->findAll();
            $this->render('admin/annonce.php', compact('annonces'));
        }
    }
    /**
     * supprime une annonce si on est admin
     *
     * @return void
     */
    public function deleteAnnonce(int $id)
    {

        if ($this->isAdmin()) {
            $annonce = new AnnonceModel();
            $annonce->delete($id);
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
