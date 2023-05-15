<?php
namespace App\Core;
//importer la class PDO

use PDO;
use PDOException;

class Db extends PDO
{
    //instansiation du singleton

    private static $instance=null;

    //les information sur la base de donnée

    private const DBHOST='localhost';
    private const DBNAME='petite_annonce';
    private const DBPASS='';
    private const DBUSER='root';

    public function __construct()
    {
        $_dsn='mysql:host='.self::DBHOST.';dbname='.self::DBNAME;

        try{

            parent::__construct($_dsn,self::DBUSER,self::DBPASS);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }

    //CREATION DE L'INSTANCE

    public static function getInstance()
    {
        if(self::$instance==null){
            self::$instance= new self;
        }
        return self::$instance;
    }

}