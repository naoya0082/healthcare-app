<?php 
class DB {
    public $dbconnect;
    public function dbconnect() {
        try {
            $this->dbconnect = new PDO('mysql:dbname=selfmade; host=127.0.0.1; port=8889; charset=utf8', 'root', 'root');
        } catch(PDOException $e) {
            echo '接続エラー:'.$e->getMessage();
        }
    }
}