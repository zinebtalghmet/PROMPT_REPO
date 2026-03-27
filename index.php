<?php
session_start();

// Ila connecté → redirect l prompts
if (isset($_SESSION['user_id'])) {
    header("Location: prompts/index.php");
    exit;
}

// Ila ma connectéch → redirect l login
header("Location: auth/login.php");
exit;
?>
