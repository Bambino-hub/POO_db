<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\AnnonceModel;

class AnnonceController extends Controller
{
    /**
     * cette methode affichera une page listant toutes les annonces 
     *
     * @return void
     */
    public function index()
    {
        $annonce = new AnnonceModel();
        $annonces = $annonce->findAll();

        // on envoie les informations a la vue
        $this->render('annonce/index.php', ['annonces' => $annonces]);

        // ou encore utiliser "compact pour envoyer les données
        // $this->render('annonce/index.php', compact('annonces'));
    }

    /**
     * fonction qui nous permet de recuperer une annonce
     *
     * @param integer $id
     * @return void
     */
    public function lire(int $id)
    {
        // on instancie le model

        $annonce = new AnnonceModel;
        $annonce = $annonce->find($id);
        // on envoie les information a la vue
        $this->render('annonce/lire.php', compact('annonce'));
    }

    public function addAnnonce()
    {
        // on verifie si l'utlisateur es connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // si l'utilisateur est connecté il peut ajouté une annonce
            // on verifie si le formulaires est complet
            if (Form::validate($_POST, ['titre', 'description'])) {
                // le formulaire est complet
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // on instacie le model
                $annonce = new AnnonceModel();

                // on hydrate l'objet
                $annonce->setTitre($titre);
                $annonce->setDescription($description);
                $annonce->setUerId($_SESSION['user']['id']);

                // on envoie dans base de donnée
                $annonce->create();

                // on redirige vers la page des annonce 
                $_SESSION['message'] = 'l\'annonce a eté ajouter avec succès';
                header('Location: index.php?p=annonce/index');
                exit;
            } else {
                // le formulaire est incomplet
                $_SESSION['message'] =  !empty($_POST) ? "le formulaire est incomplet" : '';
                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
            }
            $annonce = new Form();
            $annonce->beginForm()
                ->addLabel('titre', 'titre de l\'annonce')
                ->addInput('text', 'titre', 'titre',  $titre, [
                    'class' => 'form-control',


                ])
                ->addLabel('description', 'Texte de l\'annonce')
                ->addTextarea('description', $description, [
                    'class' => 'form-control',
                    'id' => 'description',
                ])
                ->addbutton('submit', [
                    'class' => 'btn btn-primary'
                ])
                ->endForm();
            $this->render('annonce/addAnnonce.php', ['form' => $annonce->create()]);
        } else {
            // l'utilisateur n'est pas connecté
            $_SESSION['erreur'] = 'vous devez être connecté pour accéder a cette page';
            header('Location: index.php?p=users/login');
            exit;
        }
    }

    /**
     * function to edit annonce 
     *
     * @param integer $id
     * @return void
     */
    public function editAnnonce(int $id)
    {
        // on verifie si l'utlisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // on va verifé si l'annonce exist
            // on instancie notre modèl
            $annonce = new AnnonceModel();

            // on cherche l'annonce avec l'id
            $annonce1 = $annonce->find($id);

            // l'annonce l'annonce n'exite pas 
            if (!$annonce1) {
                http_response_code(404);
                $_SESSION['erreur'] = 'l\'annonce cherchée n\'esxiste pas ';
                header('LOcation: index.php?p=annonce/index');
                exit;
            }

            // on verifie si l'utilisateur est partenaire de l'annonce ou admin
            if ($annonce1->user_id !== $_SESSION['user']['id']) {
                if (!in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
                    $_SESSION['erreur'] = "vous n'avez pas accès a cette page";
                    header('LOcation: index.php?p=annonce/index');
                    exit;
                }
            }

            // on traite le formulaire
            if (Form::validate($_POST, ['titre', 'description'])) {
                // on se protège des failles xss
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // on stock l'annonce 
                $annoncemodif =  new AnnonceModel();

                // on hydrate 
                $annoncemodif->setId($annonce1->id);
                $annoncemodif->setTitre($titre);
                $annoncemodif->setDescription($description);

                // on met a jour de l'annonce 
                $annoncemodif->update();

                //on redirige
                $_SESSION['erreur'] = 'l\'annonce à été modifié avec succès ';
                header('LOcation: index.php?p=annonce/index');
                exit;
            }
            $annonce = new Form();

            $annonce->beginForm()
                ->addLabel('titre', 'titre de l\'annonce')
                ->addInput('text', 'titre',  'titre',  $annonce1->titre, [
                    'class' => 'form-control',


                ])
                ->addLabel('description', 'Texte de l\'annonce')
                ->addTextarea('description', $annonce1->description, [
                    'class' => 'form-control',
                    'id' => 'description'
                ])
                ->addbutton('submit', [
                    'class' => 'btn btn-primary'
                ])
                ->endForm();
            // on envoies les information a la vue 
            $this->render('annonce/editAnnonce.php', ['form' => $annonce->create()]);
        } else {
            // l'utilisateur n'est pas connecté
            $_SESSION['erreur'] = 'vous devez être connecté pour accéder a cette page';
            header('Location: index.php?p=users/login');
            exit;
        }
    }
}
