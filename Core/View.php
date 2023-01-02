<?php

namespace Core;

class View {
    // Método que renderiza una vista (HTML) que no requiere de datos. Si se requiere de datos, se tiene que cargar una vista (PHP) y tendremos que mezclar con HTML
    public static function render($view){
        $file = dirname(__DIR__) . '/App/Views/' . $view;
        if(is_readable($file)){
            require $file;
        }else{
            echo $file . ': Vista no encontrada';
        }
    }
    // Método que utiliza el framework de PHP (Twig) que nos permite renderizar las vistas en HTML y pintar datos en ella
    public static function renderTwig($template, $params = []){
        // código que proporciona Twig para trabajar con sus funciones
        static $twig = null;

        if($twig === null){
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig\Environment($loader);
        }

        echo $twig->render($template, $params);
    }

}
