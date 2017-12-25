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