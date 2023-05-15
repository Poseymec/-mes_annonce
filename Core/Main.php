<?php

namespace App\Core;
use App\Controllers\MainController;


class Main
{

    public function start()
    {
        session_start();
        

        /*------------------nettoyage d'url---------------- */
        //retirer le trailing slash eventuel de l'url

        //recupere l'url

        $uri=$_SERVER['REQUEST_URI'];

        
        
        //verifier que uri n'est pas vide
        if(!empty($uri) && $uri!='/' && $uri[-1]==="/"){
            //enlever les slash
            
            $uri=substr($uri ,0,-1);
            
            //envoyer un code  de redirection permanent
            
            http_response_code(301);
            
            //rediriger vers url sans le slash
            
            header('lacation:'.$uri);
            exit;
            
            
        }
        
        /**----------------gerer les parametres d'url------------ */
        
        //p=controleur/methode/parametres
        //on separe les parametres dans un tableau
        $params=[];
        if(isset($_GET['p'])){
            
            $params=explode('/',$_GET['p']);
        }
        
        
        if($params[0]!='')
        {
            //recuperer le nom du controller a instancier
            
            //on met une majuscule en premiere lettre on ajoute le namespase complet et on ajout'controller' a la fin
            
            $controller='App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';
            
            //instancier le controller
            
            $controller=new $controller();
            
            //on verifier si le deuxieme parametre existe
            
            $action=(isset($params[0]))? array_shift($params):'index';
            
            //verifions si la methode index existe
            
            if(method_exists($controller,$action)){
                //s'il reste des parametrs on les passe a la methode
                (isset($params[0]))?  call_user_func_array([$controller,$action],$params):$controller->$action();
                
            }else{
                
                http_response_code(404);
                
                echo 'la page n\'existe pas';
            }
           

           
        }
        else
        {
            //instancier le controleur par defaut qui va rediriger vers la page d'accueil

            $controller=new MainController();

            $controller->index();
        }

        
    }
}