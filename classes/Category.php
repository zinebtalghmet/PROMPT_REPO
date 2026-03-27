<?php
class Category{
    private $conn;
    private $table = "Categories";

    public $id;
    public $title;

    public function __construct($db){
        $this->conn =$db;
    }

    Public function getAll(){
        $query = "SELECT * FROM " . $this->table;
        $stmt =$this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table . " (Title) VALUES (:title)";
        $stmt =$this->conn->prepare($query);
        $stmt->bindParam(":title",$this->title);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table . " SET Title = :title WHERE Id = :id";
        $stmt =$this->conn->prepare($query);
        $stmt->bindParam(":title",$this->title); 
        $stmt->bindParam(":id",$this->id);
        return $stmt->execute();
    }

    public function delete(){
        try {
            $query = "DELETE FROM " . $this->table . " WHERE Id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id",$this->id);
            return $stmt->execute();
        } catch(PDOException $e){
            return false;
        }
    }
}   


?>