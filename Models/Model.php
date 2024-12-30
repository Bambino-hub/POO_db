<?php

namespace App\Models;

use  App\Core\Db;

class Model extends Db
{
    // Table de la base de donnée
    protected $table;

    // Instance de Db
    private $db;

    public function create()
    {

        $champs = [];
        $inter = [];
        $valeurs = [];

        // on boucle pour eclater le tableau
        foreach ($this as $champ => $valeur) {
            // INSERT INTO annonce (titre,description,actif) VALUES (?,?,?)
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        // on transforme le tableau "champs" en une chaine de caractère
        $liste_champs = implode(',', $champs);
        $liste_inter = implode(',', $inter);

        // on peut exécuté la requete 

        return $this->requete('INSERT INTO ' . $this->table . ' ( ' . $liste_champs . ') VALUES (' . $liste_inter . ')', $valeurs);
    }

    // fonction de mise a jour d'une annonce 
    public function update()
    {

        $champs = [];
        $valeurs = [];

        // on boucle pour eclater le tableau
        foreach ($this as $champ => $valeur) {
            // UPDATE  annonce SET titre = ? , description =?, actif = ? HWRE id = ?
            if ($valeur != null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $this->id;
        // on transforme le tableau "champs" en une chaine de caractère
        $liste_champs = implode(',', $champs);

        // on peut exécuté la requete 

        return $this->requete(' UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id = ?', $valeurs);
    }

    // function display all annonce
    public function  findAll()
    {
        $query = $this->requete('SELECT*FROM ' . $this->table);
        return $query->fetch();
    }

    // fonction qui permet de supprimer une annonce
    public function delete(int $id)
    {
        return $this->requete('DELETE FROM ' . $this->table . ' WHERE id = ?', [$id]);
    }

    // fonction qui permet de recupérer les annonces ciblé
    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];

        // on boucle pour eclater le tableau
        foreach ($criteres as $champ => $valeur) {
            // SELECT * FROM annonce WHERE actif = ?
            // bindvalue (1,valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        // on transforme le tableau "champs" en une chaine de caractère
        $liste_champs = implode(' AND ', $champs);

        // on peut exécuté la requete 

        return $this->requete('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs, $valeurs)->fetchAll();
    }

    public function find(int $id)
    {
        return $this->requete("SELECT * FROM  $this->table WHERE id = $id")->fetch();
    }

    public function requete(string $sql, array $attributs = null)
    {
        // on recupère l'instance de Db
        $this->db = Db::getInstance();

        // on verifie si on a des attributs 
        if ($attributs !== null) {

            // on prépare la requête
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }

    //fonction qui nous permet de faire de l'hydratation
    public function hydrate($donnees)
    {
        foreach ($donnees as $key => $value) {
            // on recupère le nom du setter correspondant à la clé  ($key)
            $setter = 'set' . ucfirst($key);

            // on verifie si le setter existe
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
        return $this;
    }
}
