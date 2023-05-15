<?php
namespace App\models;

use App\Controllers\UsersController;

class UsersModel extends Model
{
    protected $id;
    protected $nom;
    protected $email;
    protected $password;
    protected $role;
  

    protected $table;


    public function __construct()
    {

        $this->table='users';
        
    } 


    public function findONByEmail(string $email){


        return $this->requette(" SELECT * FROM $this->table WHERE email=?",[$email])->fetch();
    }

    //la methode setSession POUR CREER LA SESSION DE L'UTILISATEUR

    public function setSession()
    {
        $_SESSION['user']=[
            'id'=>$this->id,
            'nom'=>$this->nom,
            'email'=>$this->email,
            'role'=>$this->role
        ];
    }       


    /*--------creation des methode getter et setter des differents champs du formulaire-------- */

       //getter pour le champ id

       public function getId():self
       {
           return $this->id;
       }
       //setter pour le champs id
   
       public function setId($id)
       {
           $this->id=$id;
   
           return $this;
       }
    //getter pour le champ nom

    public function getNom():self
    {
        return $this->nom;
    }
    //setter pour le champs nom

    public function setNom($nom)
    {
        $this->nom=$nom;

        return $this;
    }

       //getter pour le champ empassword
    public function getEmail():self
    {
        return $this->email;
    }
    //setter pour le champs email

    public function setEmail($email)
    {
        $this->email=$email;

        return $this;
    }

       //getter pour le champ password
    public function getPassword():self
    {
        return $this->password;
    }
    //setter pour le champs nom

    public function setPassword($password)
    {
        $this->password=$password;

        return $this;
    }
    //setter pour le role

    public function setRole($role)
    {
        $this->role=json_decode($role);

        return $this;
    }

       //getter pour le champ role
       public function getRole():array
       {
           $role= $this->role;
           $role[]='ROLE_USER';

           return array_unique($role);

       }

}