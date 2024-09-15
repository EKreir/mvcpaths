<?php

namespace Core\HTML;

/**
 * class Form
 * Permet de générer un formulaire rapidement et simplement
 * Mettre les variables et fonctions en protected pour qu'elles soient accessibles par les classes filles
 */

 // @var = variables, @param = fonctions

class Form {

    /**
     * @var array Données utilisées par le formulaire
     */

    protected $data;

    /**
     * @var string Tag utilisé pour entourer les champs
     */

    public $surround = 'p';

    /**
     * @param array $data Données utilisées par le formulaire
     */

    public function __construct($data = array())
    {
        $this->data = $data;   //On fait $this->data = $data pour récupérer les données du formulaire
    }

    /**
     * @param $html string Code HTML à entourer
     * @return string
     */

    protected function surround($html)
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    /**
     * @param $index string Index de la valeur à récupérer
     * @return string
     */

    protected function getValue($index)
    {
        if (is_object($this->data)) {
            return $this->data->$index;
        }   //Si $this->data est un objet, on retourne la valeur de l'index
        return isset($this->data[$index]) ? $this->data[$index] : null;   //Sinon, on retourne la valeur de l'index si elle existe, sinon on retourne null
    }

    /**
     * @param $name string
     * @param $label string
     * @param array $options
     * @return string
     */

    public function input($name, $label, $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        return $this->surround('<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '">');
    }

    /**
     * @return string
     */

    public function submit()
    {
        return $this->surround('<button type="submit">Envoyer</button>');
    }

}