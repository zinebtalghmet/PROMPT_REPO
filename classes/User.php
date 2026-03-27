<?php

Class User{

private $conn;
private $table = "Users";

public $id;
public $username;
public $password;
public $email;
public $role;

public function __construct($db){
    $this->conn = $db;
}

//==================registre==========================
public function registre(){
try {
$query = "INSERT INTO " . $this->table . " (Username,Password,Email) Values (:username,:password,:email)";

$stmt = $this->conn->prepare($query);

$hashed = password_hash($this->password,PASSWORD_DEFAULT);

$result =$stmt->execute([
    'username'=>$this->username,
    'password'=>$hashed,
    'email'=>$this->email
]);

    return $result;
} catch(PDOException $e){
    return false;
}
}

//==================Login==========================

public function login(){

$sql = "SELECT Id,Username,Password,Role From " . $this->table . " WHERE email =:email";
$stmt = $this->conn->prepare($sql);
$stmt->execute(['email'=>$this->email]);

$table=$stmt->fetch(PDO::FETCH_ASSOC);
if($table && password_verify($this->password,$table['Password'])){
    $this->id =$table['Id'];
    $this->username =$table['Username'];
    $this->role=$table['Role'];
    return true;
}
return false;

}
}
?>
