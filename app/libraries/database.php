<?php
    /**
     * PDO Database Class
     * connect to database
     * Create prepared statements
     * bind values
     * Return rows and results
     */
    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh;
        private $stmt;
        private $error;

        public function __construct(){
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            //crear PDO instancia
            try {
                $this->dbh = new PDO($dsn,$this->user,$this->pass,$options);
            } catch (PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        //preaparar la query
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }
        
        //asignar las variables a la query
        public function bind($param, $value, $type = null){
            if(is_null($type)){
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        //ejecutar la query
        public function execute(){
            return $this->stmt->execute();
        }

        //devolver resultado como array de objectos
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //devolver un registro como objeto
        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        //devolver numero de registros
        public function rowCount(){
            return $this->stmt->rowCount();
        }

        
    }
?>