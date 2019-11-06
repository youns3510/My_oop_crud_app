<?php

include_once(__DIR__ . "/../config/database.php");
class  Category
{
    //database connection and table name
    private $conn;
    private $table_name = "categories";

    //    class properties
    public $id;
    public $name;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();

    }

    // used by select while creating new product
    public function read()
    {
        // select all data
        $query = "SELECT `id`,`name` from `" . $this->table_name . "` order by  `name`;";
      //  $stmt = $this->conn->prepare($query);
      //  var_dump($stmt);
      $q= 'select *  from `categories`;';
        $stmt = ($this->conn)->query($q);
     
        $stmt->execute();
      
        return $stmt;
    }

    public function readName() 
    {
        $query = "select `name` from `" . $this->table_name . "` where id = ? limit 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id,PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        // return $this->name;
    }
}
