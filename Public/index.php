<?php

//constate contenant le dossier racine du projet

use App\Autoloader;
use App\Core\Main;
define('ROOT',dirname(__DIR__));



//importer l'autoloader

require_once ROOT.'/Autoloader.php';

Autoloader::registreur();
//on instancie la class main qui va demarrer l'application(rooteur)

$app=new Main();

//demarrer l'application

$app->start();