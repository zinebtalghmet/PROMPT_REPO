<?php
session_start();
include '../config/Database.php';
include '../classes/Prompt.php';
include '../classes/Category.php';

//Verifier wash l user connecte 

if(!isset($_SESSION['user_id'])){
    header("Location:../auth/login.php");
    exit;
}

$database = new Database();
$db=$database->connect();
$prompt = new Prompt($db);
$category = new Category($db);

//get all categories for dropdown
$categories = $category->getAll()->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $prompt->title =$_POST['title'];
    $prompt->content =$_POST['content'];
    $prompt->category_id =$_POST['category_id'];
    $prompt->user_id =$_SESSION['user_id'];


    if($prompt->create()){
        header("Location:index.php");
        exit;
    }else{
        $error= "Erreur lors de l'ajout";
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prompt - PromptRepo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo">
                <div class="logo-icon">P</div>
                <div class="logo-text">PromptRepo</div>
            </div>
            <div class="nav-section">
                <div class="nav-label">MENU</div>
                <a href="index.php" class="nav-item"><span class="icon">📋</span> My Prompts</a>
                <a href="create.php" class="nav-item active"><span class="icon">➕</span> Add Prompt</a>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="../admin/Dashboard.php" class="nav-item"><span class="icon">📊</span> Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="user-profile">
            <div class="user-avatar"><?= strtoupper(substr($_SESSION['username'], 0, 2)) ?></div>
            <div class="user-info">
                <div class="user-name"><?= $_SESSION['username'] ?></div>
                <div class="user-role"><?= $_SESSION['role'] == 'admin' ? 'Admin' : 'Developer' ?></div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="top-bar">
            <div>
                <h1 class="page-title">Add New Prompt</h1>
                <p class="page-subtitle">Save a tested and approved prompt to your library</p>
            </div>
        </div>

        <div class="form-container">
            <div class="form-card">
                <?php if(isset($error)) : ?>
                    <div class="error-msg"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" placeholder="Give your prompt a descriptive title" required>
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" rows="6" placeholder="Paste your tested prompt here..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" required>
                            <option value="">-- Choose a category --</option>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat['Id'] ?>"><?= $cat['Title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Save Prompt</button>
                        <a href="index.php" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>