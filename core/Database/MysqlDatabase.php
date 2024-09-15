<?php

namespace Core\Database;

use PDO;

class MysqlDatabase extends Database{

    private $dbName;
    private $dbUser;
    private $dbPass;
    private $dbHost;
    private $pdo;

    public function __construct($dbName , $dbUser = 'eliess', $dbPass = 'Eliess2001#@!', $dbHost = 'localhost')
    {
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbHost = $dbHost;
    }

    private function getPDO()
    {
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query($statement, $className = null, $one = false)   //Cette fonction permet d'exécuter une requête
    {
        $req = $this->getPDO()->query($statement);
        if (
            strpos($statement, 'UPDATE' === 0 ||
            strpos($statement, 'INSERT' === 0 ||
            strpos($statement, 'DELETE' === 0))
            )) {   //Si la requête est une requête de mise à jour, d'insertion ou de suppression
            return $req;   //On retourne le résultat
            }

        if ($className === null) {   //Si le nom de la classe est null
            $req->setFetchMode(PDO::FETCH_OBJ);   //On récupère les données sous forme d'objet
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($one) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        return $datas;
    }

    public function prepare($statement, $attributes, $className = null, $one = false)   //Cette fonction permet de préparer une requête
    {
        $req = $this->getPDO()->prepare($statement);   //On prépare la requête
        $res = $req->execute($attributes);   //On exécute la requête
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
            ) {   //Si la requête est une requête de mise à jour, d'insertion ou de suppression
            return $res;   //On retourne le résultat
            }

        if ($className === null) {   //Si le nom de la classe est null
            $req->setFetchMode(PDO::FETCH_OBJ);   //On récupère les données sous forme d'objet
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $className);
        }
        if ($one) {   //Si on veut récupérer une seule donnée
            $datas = $req->fetch();   //On récupère une seule donnée
        } else {
            $datas = $req->fetchAll();   //On récupère toutes les données
        }
        return $datas;
    }

    public function lastInsertId()
    {
        return $this->getPDO()->lastInsertId();   //Récupère l'identifiant de la dernière ligne insérée
    }

}