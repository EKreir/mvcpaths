<?php

namespace Core;

class Autoloader {

    /**
     * Class Autoloader
     * @package App
     */

    static function register()   //On crée une fonction static pour pouvoir l'appeler sans instancier la classe
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));   //On utilise la fonction spl_autoload_register pour appeler la fonction autoload
    }

    static function autoload($class)
    {
        if (strpos($class, __NAMESPACE__ . '\\') === 0) {   //On vérifie si le namespace de la classe est le même que celui de la classe Autoloader
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);   //On remplace le namespace de la classe par rien
            $class = str_replace('\\', '/', $class);   //On remplace les \ par des /
            require __DIR__ . '/' . $class . '.php';
        }
    }

}