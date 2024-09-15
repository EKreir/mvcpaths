<?php

use Core\Database\MysqlDatabase;
use Core\Config;

class App {

    public $title = "Mon site";
    private $dbInstance;
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {   // Si l'instance n'existe pas
            self::$instance = new App();
        }
        return self::$instance;   // Retourne l'instance
    }

    public static function load()
    {
        session_start();   // Démarre la session
        require ROOT . '/app/Autoloader.php';   // Charge l'autoloader
        App\Autoloader::register();   // Enregistre l'autoloader
        require ROOT . '/core/Autoloader.php';   // Charge l'autoloader
        Core\Autoloader::register();   // Enregistre l'autoloader
    }

    public function getTable($name)
    {
        $className = '\\App\\Table\\' . ucfirst($name) . 'Table';   // Récupère le nom de la classe
        return new $className($this->getDb());   // Retourne une nouvelle instance de la classe
    }

    public function getDb()
    {
        $config = Config::getInstance(ROOT . '/config/config.php');   // Récupère la configuration
        if (is_null($this->dbInstance)) {   // Si l'instance n'existe pas
            $this->dbInstance = new MysqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));   // Crée une nouvelle instance de MysqlDatabase
        }
        return $this->dbInstance;
    }

}