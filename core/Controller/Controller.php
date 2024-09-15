<?php

namespace Core\Controller;

class Controller {

    protected $viewPath;
    protected $templates;

    protected function render($view, $variables = [])
    {
        ob_start();
        extract($variables);
        require($this->viewPath . str_replace('.', '/', $view) . '.php');
        $content = ob_get_clean();
        require($this->viewPath . 'template/' . $this->templates . '.php');
    }

    protected function notFound()
    {
        header("HTTP/1.0 404 Not Found");   // Envoie un header 404
        die('Page introuvable');   // Arrête le script
    }

    protected function forbidden()
    {
        header("HTTP/1.0 403 Forbidden");   // Envoie un header 403
        //die('Accès interdit');   // Arrête le script
    }

}