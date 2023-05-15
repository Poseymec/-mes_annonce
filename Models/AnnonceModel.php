<?php

//class de recuperation de la table

namespace App\models;
use App\Core\Db;

class AnnonceModel extends Model
{
    protected $id;
    protected $titre;   
    protected $description;    
    protected $date_creation;
    protected $actif; 
    protected $user_id;  





    public function __construct()
    {
        $this->table='annonce';
        
    }

    /*-----les methode getter et setter de touts les champs du tableau------ */

    //fonction du champ id
    public function setId( int $id){
        $this->id=$id;
        return $this;
    }
    public function getId(){
        return $this->id;
    }
     //fonction du champ titre
     public function setTitre( string $titre){
        $this->titre=$titre;
        return $this;
    }
    public function getTitre(){
        return $this->titre;
    }
     //fonction du champ description
     public function setDescription( string $description){
        $this->description=$description;
        return $this;
    }
    public function getDescription(){
        return $this->description;
    }
     //fonction du champ actif
     public function setActif( int $actif){
        $this->actif=$actif;
        return $this;
    }
    public function getActif(){
        return $this->actif;
    }
      //fonction du champ date_creation
      public function setDate_creation( int $date_creation){
        $this->date_creation=$date_creation;
        return $this;
    }
    public function getDate_creation(){
        return $this->date_creation;
    }
     //getter pour le champ user_id
     public function getUser_id():int
     {
         return $this->user_id;
     }
     //setter pour le champs user_id
    
     public function setUser_id( int $user_id)
    {
         $this->user_id=$user_id;
         
         return $this;
     }
}



