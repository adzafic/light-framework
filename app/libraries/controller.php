<?php
    /**
     * Controlador base 
     * Cargar los modelos y vistas
     * 
     */
    class Controller {
        // Cargar modelo
        public function model($model){
            // requerir modelo
            require_once('../app/models/'.$model.'.php');
            return new $model();
        }

        //cargar vistas
        public function view($view,$data = []){
            //comprobar si el archvo existe
            if(file_exists('../app/views/'.$view.'.php')){
                require_once('../app/views/'.$view.'.php');
            }else{
                // vista no existe
                die("la Vista ($view) No existe");
            }
        }
    }
?>