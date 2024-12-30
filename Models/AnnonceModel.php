<?php

namespace App\Models;

class AnnonceModel extends Model
{
    protected $id;
    protected $titre;
    protected $description;
    protected $created_at;
    protected $actif;
    protected int $user_id;
    public function __construct()
    {
        $this->table = "annonce";
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of titre
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     */
    public function setTitre($titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     */
    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of actif
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set the value of actif
     */
    public function setActif($actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUerId(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUerId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
