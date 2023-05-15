<?php
namespace App;
//cretaion de l'autoloarder du projet

class Autoloader
{
    public static function registreur()
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);


    }

    private static function autoload($class)
    {
        //retirer le dossier    APP\ du chemin

        $class=str_replace(__NAMESPACE__.'\\','',$class);

        //remplacer les anti slash par les slash

        $class=str_replace('\\','/',$class);

        //creer le nouveau chemin
        $fichier=__DIR__.'/'.$class.'.php';

        if(file_exists($fichier)){
            require_once($fichier);
        }
    }

}