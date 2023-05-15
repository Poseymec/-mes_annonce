<?php
namespace App\Controllers;

use App\models\AnnonceModel;

class AdminController extends Controller
{


    public function index()
    {
        //on verifie si on est admin

  

        if($this->isAdmin()){

            $this->render('admin/index',[],'admin');

        }
    }

    /**affichier la liste des annonces sous forme de tableau */
    public function annonce(){
        if($this->isAdmin()){

            $annoncemodel= new AnnonceModel;
            $annonces=$annoncemodel->findAll();


        
            $this->render('admin/annonce',compact('annonces'));

        }

    }
     /***methode de suppression des annonces */

     public function supprimer(int $id){
        if($this->isAdmin()){

            //verifier si l'utilisateur a le droit de le faire
            if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){

                $annoncemodel=new AnnonceModel;
                $annonce=$annoncemodel->find($id);

                

                if($annonce->user_id !== $_SESSION['user']['id']){
                    $_SESSION['erreur']="vous n'etes pas autorisé a supprimer cette annonce";
                    header('location: /admin/annonce');
                    exit;
    
                }
    
    
                $annoncemodel->delete($id);
                $_SESSION['message']="annonces supprimée avec success";
                header('location: /admin/annonce');
                exit;
    
           
            }else{
                $_SESSION['erreur']="vous n'etes pas autorisé a supprimer cette annonce";
                header('location: /admin/annonce');
                exit;
    
            }
        }

            
      

    }


    /**methode pour activer ao desactiver les annonces */

    public function actif(int $id){
        //verifier si l'utilisateur a le droit

        if($this->isAdmin()){
            $annoncemodel=new AnnonceModel;

            $annonce=$annoncemodel->find($id);

            if($annonce){
                $annonce=$annoncemodel->hydrate($annonce);

                $annonce->setActif($annonce->getActif()? 0:1);

                $annonce->update($id ,$annonce);
            }
        }
    }

    /**
     * fonction de verification si on est admin ou non
     */

    private function isAdmin()
    {

        //on verifie si on est connecté et si role adamin est dans la session

        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN',$_SESSION['user']['role'])){

            return true;

        }else{

            $_SESSION['erreur']='vous ne pouvez pas acceder a cette zone';

            header('location:/');

        }


    }


}