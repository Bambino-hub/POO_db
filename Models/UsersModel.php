<?php

namespace App\Models;

class UsersModel extends Model
{
    protected $id;
    protected $email;
    protected $password;
    protected $roles;

    public function __construct()
    {
        $this->table = "users";
    }

    /**
     * function to get email for one user
     *
     * @param string $email
     * @return void
     */
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM $this->table WHERE email= ?", [$email])->fetch();
    }

    /**
     * create session for uuser
     *
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles
        ];
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
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        // array_unique nous permet ne pas avoir de doublons dans le tableau
        return array_unique($roles);
    }

    /**
     * Set the value of roles
     */
    public function setRoles($roles): self
    {
        $this->roles = json_decode($roles);

        return $this;
    }
}
