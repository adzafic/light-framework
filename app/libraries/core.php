<?php
    /**
     * App Core Class
     * Crea Url y carga Core Controladores
     * URL FROMAT -/controller/method/params
     */
    class Core {
        protected $currentController = "Pages";
        protected $currentMethod = "index";
        protected $params = [];

        public function __construct(){
            $url = $this->getUrl();
            //buscamos el controlador
            if(file_exists('../app/controllers/' . ucwords($url[0]). '.php')){
              // si existe sustituomos el controlador por defecto
              $this->currentController = ucwords($url[0]);
              // boramos el index 0
              unset($url[0]);
            }
            require_once '../app/controllers/'. $this->currentController . '.php';
            // Creamos la instancia
            $this->currentController = new $this->currentController;

            //comprobar por la segunda parte de la url
            if(isset($url[1])){
                //comprobar si el methodo existe en el controlador
                if(method_exists($this->currentController,$url[1])){
                    $this->currentMethod = $url[1];
                }
                unset($url[1]);
            }

            // get params

            $this->params = $url ? array_values($url) : [];

            // ejecutar la funcion callback con una array como parametro
            call_user_func_array([$this->currentController,$this->currentMethod],$this->params);


        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }

    }
    
?>