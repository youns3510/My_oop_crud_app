<?php
class Database
{
    private $host = "localhost";
    private $db_name    =  "my_php_oop";
    private $user       =  "my_php_oop_user";
    private $pass       =  "sDFpC4Qsu2xAn7NM";
    public $conn;



    public function getConnection()
    {
        $this->conn = null;
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};";
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), (int) $e->getCode());
        }

        return $this->conn;
    }
}
