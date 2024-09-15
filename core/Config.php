<?php

namespace Core;

class Config {

    private $settings = [];
    private static $instance;

    public static function getInstance($file)
    {
        if (is_null(self::$instance)) {   // Si l'instance n'existe pas
            self::$instance = new Config($file);   // On crée une nouvelle instance
        }
        return self::$instance;
    }

    public function __construct($file)
    {
        $this->settings = require($file);   // On récupère les paramètres du fichier de configuration
    }

    public function get($key)
    {
        if (!isset($this->settings[$key])) {   // Si la clé n'existe pas
            return null;
        }
        return $this->settings[$key];
    }

}