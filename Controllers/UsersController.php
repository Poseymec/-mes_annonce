<?php

namespace App\Controllers;
use App\Core\Form;
use App\models\UsersModel;

class UsersController extends Controller
{    
    //connection des utilisateur

    public function login()
    {

        //verifier si le formulaire est complet

        if(Form::validate($_POST,['email','password'])){
            //le formulaire est valide
            
           $email=strip_tags($_POST['email']);
           $password=sha1($_POST['password']).'pires';
    
            
            //instancier l'objet 
            $usermodel= new UsersModel;
            
            //on cherche dans la base l'utilisateur avec l'email entré
            $user=$usermodel->findONByEmail($email);

            //verifier si $user n'est pas rempli

            if(!$user){

                //s'il ya rien on retourne a la page principal
                
                $_SESSION['erreur']='adresse email et/ou mot de passe non valide';
                header('location:/users/login');
                exit;

            }else{

                //si l'objet est rempli
                //on tranforme l'objet en tableau

               $arraymodel=(array)$user;

             
    

               $users=$usermodel->hydrate($user);
               
             

               if($password!=$arraymodel['password']){
                   //le mot de passe est bon
                   //si le mode de passe est mauvais
                   $_SESSION['erreur']='adresse email et/ou mot de passe non valide ';
                   header('location:/users/login');
                   exit;
                 }else{
                    //on crée la session
                    $users->setSession();
                    
                    header('location:/');
                    exit;
                    
                }
    
                
            }


        }


       

        $form=new Form;

        $form->startForm()
            ->ajoutLablFor('email','email')
            ->ajoutInput('email','email',['class'=>'form-control', 'id'=>'email'])
            ->ajoutLablFor('password','mot de passe:')
            ->ajoutInput('password','password',['id'=>'password' ,'class'=>'form-control'])
            ->ajoutBouton('me connecter',['class'=>'btn btn-primary'])
            ->endForm();

       

   

       $this->render('/users/login',['loginForm'=>$form->create()]);

    }

    //inscription des utilisateur

    public function inscription(){

        //verifier si les champs son valides

        if(Form::validate($_POST,['nom','email','password']))
        {
            //si le formaulaire est valide?
            //on nettoie l'adresse email et le nom

            $email=strip_tags($_POST['email']);
            $nom  =htmlspecialchars($_POST['nom']);

            //on chiffre le mot de passe
            $password=sha1($_POST['password']).'pires';

           //hydrater les données

           $user=new UsersModel;
           $users=$user->setEmail($email)
                ->setNom($nom)
                ->setPassword($password);
                
                //strocker les données dans la base

            $user->create($users);
            

        }
       
        $form= new Form;

        $form->startForm()
        ->ajoutLablFor('nom',' nom')
        ->ajoutInput('nom','nom',['class'=>'form-control','id'=>'nom'])
        ->ajoutLablFor('email','email')
        ->ajoutInput('email','email',['class'=>'form-control', 'id'=>'email'])
        ->ajoutLablFor('password','mot de passe:')
        ->ajoutInput('password','password',['id'=>'password' ,'class'=>'form-control'])
        ->ajoutBouton('m\'inscrire',['class'=>'btn btn-primary'])
        ->endForm();

        $this->render('/users/inscription',['inscriptionForm'=>$form->create()]);

    }

    //la methode de deconnexion

    public function deconnexion()
    {
        unset($_SESSION['user']);
        header('location:/users/login');
        exit;
    }

}