<?php

namespace App\Controllers;
use App\Controllers\UsersController;


 abstract class Controller
{

    public function render(string $fichier,array $donne=[],$page='defaut' ){

        //extraire les données du tableau

        extract($donne);
        //utiliser le buffer pour afficher les annonces dans defaut.php

        ob_start();


        //creer le chemin pour pour la page d'afficharge

        require_once(ROOT.'/Views/'.$fichier.'.php');

        $content=ob_get_clean();

        require_once(ROOT.'/Views/'.$page.'.php');





    }


 

    
}