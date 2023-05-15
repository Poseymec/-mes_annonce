<?php
//model de class
 namespace App\models;
 use App\Core\Db;

   abstract class Model extends Db
 {
    //variable qui va contenir le nom de la table

    protected $table;
   
    //variable qui va recevoir l'instance

    private $db;

    //fonction findAll  qui permet de recuperer toutes  les information dans la base de donnée

    public function findAll()
    {
        $requette=$this->requette(' SELECT * FROM '.$this->table);

        return $requette->fetchAll();
    }

    //fonction findBy qui permet de recuperer un element en fonction d'un indice specifique

    public function findBy(array $element)
    {   //les tableau qui vont contenir les differents elements du tableau
        $champs=[];
        $valeurs=[];
        //parcourir le tableau pour recuperer  les elements sont la
        foreach($element as $champ=>$valeur){
            $champs[]="$champ=?";
            $valeurs[]=$valeur;

            
            
        }
        //transformer les elements du tableau champs en chaines de caractere

        $liste_champs=implode('AND',$champs);

        //faire la methode qui va gerer la requette

         $requette=$this->requette(' SELECT * FROM '.$this->table.' WHERE '.$liste_champs,$valeurs);

         return $requette->fetchAll();

    }
    //methode find qui permet de selectionner un element en fonction de l'id
    public function find( int $id)
    {
      
        $requette=$this->requette(' SELECT * FROM '.$this->table.' WHERE id='.$id);

        return $requette->fetch();
    }
    
    //methode pour inserer les données dans une table

    public function create(model $donnes)
    {
        //les tableaux qui vont contenir les differents valeurs de $elements

        $champs=[];
        $values=[];
        $valeurs=[];

        //utiliser une boucle pour demonter le tableau $elements

        foreach($donnes as $champ=>$valeur){
            if($valeur!=null &&$champ!='db' && $champ!='table'){

                $champs[]=$champ;
                $values[]='?';
                $valeurs[]=$valeur;
            }

        }
        //on transforme les differents elements des tableaux en chaine de caractere

        $liste_champs=implode(', ',$champs);
        $liste_values=implode(', ',$values);

        //effectuer la requete

        return $this->requette(' INSERT INTO '.$this->table.' ( '.$liste_champs.' )VALUES( '.$liste_values.' ) ',$valeurs);
    }


    //methode update qui permet de modifier les information dans la table
    
    
    public function update( int $id,  $donnes)
    {
        //les tableaux qui vont contenir les differents valeurs de $elements

        $champs=[];

        $valeurs=[];

        //utiliser une boucle pour demonter le tableau $elements

        foreach($donnes as $champ=>$valeur){
            if($valeur!==null && $champ!='db' && $champ!='table' ){

                $champs[]="$champ=?";
             
                $valeurs[]=$valeur;
            }

        }
        $valeurs[] =$id;
        //on transforme les differents elements des tableaux en chaine de caractere

        $liste_champs=implode(', ',$champs);
     

        //effectuer la requete

        return $this->requette(' UPDATE '.$this->table.' SET '.$liste_champs.' WHERE id=? ',$valeurs);
    }

    //methode de suppression delete
    public function delete( int $id)
    {
        

        //effectuer la requete

        return $this->requette(' DELETE FROM '.$this->table.' WHERE id  = '.$id);
    }

    public function hydrate( object $donnees)
    {
        foreach($donnees as $key => $value){
            // On récupère le nom du setter correspondant à la clé (key)
            // titre -> setTitre
            $setter = 'set'.ucfirst($key);
            
            // On vérifie si le setter existe
            if(method_exists($this, $setter)){
                // On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }







    //la fonction qui va gerer la requette grace a l'instance

    public function requette(string $sql  ,array $attributs=null)
    {
        //appel de l'instance

        $this->db=Db::getInstance();

        //verifier si le tableau des attributs contient un element

        if($attributs!==null){
            //requete preparé
            $requette=$this->db->prepare($sql);
            $requette->execute($attributs);
            return $requette;
        }else{
            //requete simple
            return $this->db->query($sql);
        }

        
    }
 }

 

