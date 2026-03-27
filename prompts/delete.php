<?php
session_start();
include '../config/Database.php';
include '../classes/Prompt.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$database = new Database();
$db = $database->connect();

$prompt = new Prompt($db);
$prompt->id = $_GET['id'];

// Vérifier wach had le prompt dial l'user wla admin
$stmt = $prompt->getById();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && ($row['User_Id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin')) {
    $prompt->delete();
}

header("Location: index.php");
exit;
?>
