<?php
class Db{
    public $pdo;

    public function getPdo(){
        $this->pdo=null;
        try{
            $this->pdo=new PDO("mysql:host=localhost;dbname=theater_db;charset=utf8", "root", "root");
        }
        catch(PDOException $ex){
            echo "Connection error: ".$ex->getMessage();
        }
        return $this->pdo;
    }
}
?>