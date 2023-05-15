<?php
namespace App\Controllers;

use App\Core\Form;
use App\models\AnnonceModel;

class AnnoncesController extends Controller
{
    public function index(){

        //AFFICHER LES ANNONCES
        $annoncemodel= new AnnonceModel;

        $annonces=$annoncemodel->findAll();
       

        //charger les annonces dans la page views

        $this->render('/annonces/index',compact('annonces'));
    }

        
        
        
        
        
    public function lire(int $id){

        $annoncemodel=new AnnonceModel;
        $annonces=$annoncemodel->find($id);

        $this->render('/annonces/lire',compact('annonces'));

    }

    //methode pour ajouter kes annonces

    public function ajouter()
    {
        //verifier si l'utilsateur est connecté
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){
            //l'utilisateur est connecter

            //verifier que le formulaire est complet
            if(Form::validate($_POST,['titre','description'])){
                /**si le formulaire est complet, on se protege des erreur xss et autres attaques */

                $titre=strip_tags($_POST['titre']);
                $description=strip_tags($_POST['description']);

                //instanciation de du model
                $annoncemodel=new AnnonceModel;

                //on fait l'hydratation des données

                $annonce=$annoncemodel
                             ->setTitre($titre)
                             ->setDescription($description)
                             ->setUser_id($_SESSION['user']['id']);

                //enregistrer les données

                $annoncemodel->create($annonce);

                //rediriger 

                $_SESSION['message']='annonce ajoutée avec succes';

                header('location:/');
                exit;

                //creation du formulaire
    
    
            }
            $form=new Form;

            $form->startForm()
                 ->ajoutLablFor('titre','titre de l\'annonce')
                 ->ajoutInput('text','titre',['id'=>'titre','class'=>'form-control'])
                 ->ajoutLablFor('description','description')
                 ->ajoutTextarea('description','',['id'=>'description','class'=>'form-control'])
                 ->ajoutBouton('ajouter',['class'=>'btn btn-primary'])
                 ->endForm();

                 $this->render('/annonces/ajouter',['ajouterForm'=>$form->create()]);

        }else{

            //l'utilisateur n'est oas connecté
            $_SESSION['erreur']='inscrivez-vous ou connectez-vous pour ajouter une annonces';
            header('location:/users/login');
        }

    }

    //modifier les annonces

    public function modifier( int $id){
        //verifier si l'utilsateur est connecté
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){

            //instancier l'objet annonceModel

            $annoncemodel=new AnnonceModel;
            

                //on verifie que l'annonce existe
            $annonce=$annoncemodel->find($id);

            if(!$annonce){
                http_response_code(404);
                $_SESSION['erreur']="l'annonces recherché n 'existe pas";
                header('location:/admin');
                exit;
            }else{
                
                //on verifier si l'annonce appartient a l'utilisateur
                if($annonce->user_id!==$_SESSION['user']['id']){
                    $_SESSION['erreur']="vous n'etes pas autoriser a modifier cette annonce";
                    header('location:/admin/annonce');
                        exit;
                
                                    
                }else{

                    //traiter  le formulaire de modification

                    if(Form::validate($_POST,['titre','description'])){
                        $titre=strip_tags($_POST['titre']);
                        $description=strip_tags($_POST['description']);
        
                       
        
                        //on fait l'hydratation des données
        
                        $annonces=$annoncemodel
                                    ->setId($id)
                                    ->setTitre($titre)
                                     ->setDescription($description);
                                     
        
                        //enregistrer les données
        
                        $annoncemodel->update( $id ,$annonces);
                        $_SESSION['message']="annonces modifié avec success";
                        header('location: /admin/annonce');
                        exit;


        
                    }

                    //tanformer l'objet en tableau

                    //$arraymodel=(array)$annonce;

                    //var_dump($arraymodel);


                    //creation du formulaire de modification

                    $form=new Form;
                            
                    $form->startForm()
                        ->ajoutLablFor('titre','titre de l\'annonce')
                        ->ajoutInput('text','titre',['id'=>'titre','class'=>'form-control' ,'value'=>$annonce->titre])
                        ->ajoutLablFor('description','description')
                        ->ajoutTextarea('description',$annonce->description,['id'=>'description','class'=>'form-control'])
                        ->ajoutBouton('modifier',['class'=>'btn btn-primary'])
                        ->endForm();
                            
                        $this->render('/annonces/modifier',['modifierForm'=>$form->create()]);
                }

            }
            

        } else{
            //lutilisateur n'existe pas
            $_SESSION['erreur']="connectez-vous pour acceder a cette page";
            header('location:/users/login');
            exit;
        } 

   }

}