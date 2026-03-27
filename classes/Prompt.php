<?php
class Prompt {
private $conn;
private $table = "Prompts";

public $id;
public $title;
public $user_id;
public $category_id;
public $content;

public function __construct($db){
    $this->conn =$db;
}

public function getAll(){
    $query="SELECT Prompts.Id,Prompts.Title,Prompts.content,Prompts.Created_at,Prompts.User_Id,
    Users.Username,
    Categories.Title As Category_Title
    FROM Prompts
    INNER JOIN Users ON Prompts.User_Id = Users.Id
    INNER JOIN Categories ON Prompts.Category_Id=Categories.Id";
    $stmt=$this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

public function create(){
    $query= "INSERT INTO " . $this->table . " (Title,content,User_Id,category_Id) 
    VALUES(:title,:content,:user_id,:category_id)";
    $stmt=$this->conn->prepare($query);
    $stmt->bindParam(":title",$this->title);
    $stmt->bindParam(":content",$this->content);
    $stmt->bindParam(":user_id",$this->user_id);
    $stmt->bindParam(":category_id",$this->category_id);
    return $stmt->execute();
}

public function update(){
    $query = "UPDATE " . $this->table . " SET Title=:title,content=:content,Category_Id=:category_id
    WHERE Id = :id ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":title",$this->title);
    $stmt->bindParam(":content",$this->content);
    $stmt->bindParam(":category_id",$this->category_id);
    $stmt->bindParam(":id",$this->id);
    return $stmt->execute();
}

public function getById(){
    $query = "SELECT * FROM " . $this->table . " WHERE Id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    return $stmt;
}

public function delete(){
    $query="DELETE FROM " . $this->table . " WHERE Id = :id";
    $stmt=$this->conn->prepare($query);
    $stmt->bindParam(":id",$this->id);
    return $stmt->execute();
}

//filtre methode
public function getByCategory($category_id){
    $query = "SELECT Prompts.Id,Prompts.Title,Prompts.content,Prompts.Created_at,Prompts.User_Id,
    Users.Username,
    Categories.Title As Category_Title
    FROM Prompts
    INNER JOIN Users ON Prompts.User_Id = Users.Id
    INNER JOIN Categories ON Prompts.Category_Id = Categories.Id
    WHERE Category_Id = :category_id";

$stmt =$this->conn->prepare($query);
$stmt->bindParam(":category_id",$category_id);
$stmt->execute();
return $stmt ;
}
}

?>