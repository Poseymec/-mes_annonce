<?php
namespace App\Core;

//generateur de formulaire
class Form 
{
   //variable qui generateur de formulaire
    private $formCode='';

    //methode qui genere le formulaire html
     public function create()
     {
        return $this->formCode;
     }

     //methode de validation si tous les champs son remplis 
     // $form=tableau issu du formulaire $_post ou $_get
     //$champs variable listant les champs du tableau $form 

     public static function validate(array $form, array $champs)
     {
        //on parcourt les champs

        foreach($champs as $champ) {
            //verifier si les champs sont vide dans le formulaire
            if(!isset($form[$champ])|| empty($form[$champ])){

               //on sort de la bloucle et on retourne false
               return false;
            }

        }
        return true;
     }
     //methode qui permet d'ajouter les attributs envoyés a la balise
     //attributs tableau associatif['class'=>'form- control','required'=>true]

     private function ajoutAttributs(array $attributs): string
     {

      //initialiser une chaine de caracteres

      $str='';

      //lister les attributs 'courts'
      $courts=['checked','disabled','readonly',
      'multiple','required','autofocus','novalidate','formnovalidate'];
      // on boucle le tableau des attributs

      foreach($attributs as $attribut=>$valeur){

         //verifier si l'attribut est dans la liste courts
         if (in_array($attribut,$courts)&& $valeur==true){
            $str .= " $attribut";
         }
         else{
            //on ajoutr attribut='valeur'

            $str .= " $attribut='$valeur'";
         }
      }


      return $str;


     }
     //balise d'ouverture du formulaire
     public function startForm(string $method='POST', string $action='#' ,array $attributs=[]):self
     {
      //on cree la balise form

      $this->formCode .= "<form action='$action' method='$method'";

      //on ajoute les attributs 
      $this->formCode .= $attributs? $this->ajoutAttributs($attributs).'>':'>';

      return $this;

     }

     //balise de fermeture du formulaire

     public function endForm():self
     {
      $this->formCode .= '</form>';

      return $this;
     }
     //ajout d'un labal 

     public function ajoutLablFor(string $for,string $texte, array $attributs=[]):self
     {
      //on ouvre la balise
      $this->formCode .= "<label for='$for'";

      //ajoute les attributs

      $this->formCode .= $attributs? $this->ajoutAttributs($attributs):'';

      //on ajoute le texte
      $this->formCode .= ">$texte</label>";
      return $this;
     }

     public function ajoutInput( string $type, string $nom ,array $attributs=[]):self
     {
      //ouverture de la balise

      $this->formCode .= "<input type='$type' name='$nom'";


      //ajouter les attributs

      $this->formCode .= $attributs? $this->ajoutAttributs($attributs).'>': '>';

      return $this;
     }

     //ajout du textarrea

     public function ajoutTextarea(string $nom, string $valeur='',array $attributs=[]):self
     {
       //ouverture de la balise

       $this->formCode .= "<textarea name='$nom'";


       //ajouter les attributs
 
       $this->formCode .= $attributs ? $this->ajoutAttributs($attributs): '';

       $this->formCode .= ">$valeur</textarea>";
 
       return $this;

     }

     //ajout de la methode select

     public function ajoutSelect(string $nom ,array $options,   array $attributs=[]):self
     {
      //on cree le <select 
      
      $this->formCode .="<select name='$nom'";


      //ajouter les attributs

      $this->formCode .= $attributs? $this->ajoutAttributs($attributs).'>':'>';

      foreach($options as $valeur=>$texte){
         $this->formCode .= "<option value='$valeur'>$texte</option>";
      }

      //on ferme la balise select

      $this->formCode .= "</select>";

      return $this;



     }

     //ajout du button

     public function ajoutBouton(string $texte,array $attributs=[]):self
     {

      $this->formCode .= "<button";

      //ajout des attributs
      $this->formCode .= $attributs? $this->ajoutAttributs($attributs): '';

      //ajout  du texte et fermeture de la balise

      $this->formCode .= ">$texte</button>";
      return $this;
     }

}