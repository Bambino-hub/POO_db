<?php

namespace App\Core;

class Form
{

    private  $formcode = '';

    /**
     * benere le formulaire HTML
     *
     * @return string
     */
    public function create()
    {
        return $this->formcode;
    }

    /**
     * valide si tous les champs propopsés sont rempli
     *
     * @param array $from Tableau issu du formilaire 
     * @param array $champs Tableau listnt les champs obligatoires
     * @return bool
     */
    public static function validate(array $from, array $champs)
    {
        // on parcourt les champs 
        foreach ($champs as $champ) {
            // si le champ est absent ou vide dans le formulaire
            if (!isset($from[$champ]) || empty($from[$champ])) {
                // on sort en retournant false
                return false;
            }
        }
        return true;
    }

    /**
     * ajoute les attribut evoyés a la balise
     *
     * @param array $attributs Tableau associatif [
     * 'class' => 'form_control', 'required' => true]
     * @return string chaine de caratère génée
     */
    public function ajoutAttribut(array $attributs): string
    {
        // on initialise une chaine de caractère
        $str = '';

        // on liste les attributs courts
        $courts = [
            'checked', 'desabled', 'readonly', 'multiple',
            'required', 'autofocus', 'novalidate', 'fromnovalidate'
        ];

        // on boucle sur le tableau d'attribut
        foreach ($attributs as $attribut => $valeur) {
            if (in_array($attribut, $courts)) {
                $str .= "  $attribut";
            } else {
                $str .= " $attribut =\"$valeur\"";
            }

            return $str;
        }
    }

    /**
     * function to open tag from 
     *
     * @param string $method default post 
     * @param string $action page which can trait
     * @param array $attributs
     * @return self
     */
    public function beginForm(string $method = 'post', string $action = '#', array $attributs = []): self
    {
        // On crée la balise form
        $this->formcode .= "<form action ='$action' method='$method'";

        // on ajoute les attributs eventuels
        $this->formcode .= $attributs ? $this->ajoutAttribut($attributs) . '>' : '>';

        return $this;
    }

    /**
     * tag to close form
     *
     * @return self
     */
    public function endForm(): self
    {
        $this->formcode .= '</form>';
        return $this;
    }

    /**
     * function to add label
     *
     * @param string $for
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function addLabel(string $for, string $text, array $attributs = []): self

    {
        // open tag
        $this->formcode .= "<label for='$for'";

        // we add attribute 
        $this->formcode .= $attributs ? $this->ajoutAttribut($attributs) : '';

        // we add text
        $this->formcode .= ">$text</label>";

        return $this;
    }


    /**
     * function to add input
     *
     * @param string $type
     * @param string $name
     * @param array $attributs
     * @return self
     */
    public function addInput(string $type, string $name, string $id, string $value = '', array $attributs = []): self
    {
        // open tag
        $this->formcode .= "<input type='$type' name='$name' id='$id' value='$value'";
        $this->formcode .= $attributs ? $this->ajoutAttribut($attributs) . '>' : '>';

        return $this;
    }


    /**
     * function for texteara
     *
     * @param string $name
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function addTextarea(string $name, string $text = '', array $attributs = []): self
    {
        // open tag
        $this->formcode .= "<textarea name='$name'";

        // we add atribute
        $this->formcode .= $attributs ? $this->ajoutAttribut($attributs) : '';

        // on ajoute le text 
        $this->formcode .= ">$text</textarea>";
        return $this;
    }


    /**
     * function to add select
     *
     * @param string $name
     * @param array $option
     * @param array $attributs
     * @return self
     */
    public function addSelect(string $name, array $option, array $attributs = []): self
    {

        // we create the select
        $this->formcode .= "<select name='$name";

        // we add attribute
        $this->formcode .= $attributs ? $this->ajoutAttribut($attributs) . '>' : '>';

        // we add options 
        foreach ($option as $value => $text) {
            $this->formcode .= "<option value=\"$value\">$text</option>";

            // we close tag select
            $this->formcod .= '</select>';
        }
        return $this;
    }

    /**
     * function to add button
     *
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function addbutton(string $text, array $attributs = []): self
    {
        // we add button
        $this->formcode .= '<button';

        // we add attribute
        $this->formcode .= $attributs ? $this->ajoutAttribut($attributs) : '';

        // we add text
        $this->formcode .= ">$text</button>";
        return $this;
    }
}
