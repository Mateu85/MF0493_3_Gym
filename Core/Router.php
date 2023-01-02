<?php

namespace Core;

class Router{

    protected $routes;
    /*
    * Constructor:
    * llama al método de buildRoutes() cada vez que se crea un objeto Router
    */
    function __construct(){
        $this->readRoutes();
    }
    /*
    * buildRoutes(): recoge las rutas de 'routes.json'
    */
    public function readRoutes(){
        $content = file_get_contents(dirname(__DIR__) . '/Core/Config/routes.json');
        $this->routes = json_decode($content);
        // CHECK
        // var_dump($this->routes);
    }
    /*
    * getController(): Devuelve el controlador encargado de atender la URL
    */
    public function getController($url){
        // (array)$this->routes : convierte el atributo en array
        $routesArray = (array)$this->routes;
        // CHECK
        // var_dump($routesArray);

        // elimina toda el texto de la url precedido de '/'
        $url = ltrim($url, '/');
        // Nos quedamos con el texto después de '/'
        $url = substr($url, strpos($url, '/') + 1);
        // CHECK
        // echo $url;

        // Comprueba si la 'key' del array existe: La ruta configurada en 'routes.json', con la solicitada por el usuario URL
        if(array_key_exists($url, $routesArray)){
            // Se crea una variable donde guardamos el 'string' del controlador con otro 'string' (namespace) delante
            $result = '\\App\Controllers\\' . $routesArray[$url]->controller;
            // CHECK
            // echo $result;
            // Se crea instancia del controlador pertinente y se devuelve al FrontController
            $reflector = new \ReflectionClass($result);
            return $reflector->newInstance();

        } else { View::renderTwig('404.html'); exit; }
    }
    // TODO Challenge 4: Añadir el código PHP que se indica en el ejercicio del Challenge 4
    /*
    * getAction(): Devuelve la accion solicitada en 'routes.json'
    */
    public function getAction($url){
        // (array)$this->routes : convierte el atributo en array
        $routesArray = (array)$this->routes;
        // CHECK
        // var_dump($routesArray);

        // elimina toda el texto de la url precedido de '/'
        $url = ltrim($url, '/');
        // Nos quedamos con el texto después de '/'
        $url = substr($url, strpos($url, '/') + 1);
        // CHECK
        // echo $url;

        // Comprueba si la 'key' del array existe: La ruta configurada en 'routes.json', con la solicitada por el usuario URL
        // Se retorna una variable donde guardamos el 'string' de la acción
        return $routesArray[$url]->action;
    }
    // Final TODO Challenge 4

}
