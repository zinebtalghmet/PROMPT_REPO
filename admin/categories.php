<?php
session_start();
include '../config/Database.php';
include '../classes/Category.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location:../auth/login.php");
    exit;
}

$database=new Database();
$db=$database->connect();
$category = new Category($db);


//admin ajoute une categorie
if($_SERVER['REQUEST_METHOD']== 'POST' && isset($_POST['add'])){
    $category->title = $_POST['title'];
    $category->create();
    header("Location:categories.php");
    exit;
}


//Modifier
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['edit'])){
    $category->id = $_POST['id'];
    $category->title = $_POST['title'];
    $category->update();
    header("Location:categories.php");
    exit;
}

//Supprimer
if(isset($_GET['delete'])){
    $category->id = $_GET['delete'];
    $category->delete();
    header("Location:categories.php");
    exit;
}

$categories = $category->getAll()->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - PromptRepo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar" style="background:#0F172A;">
        <div class="sidebar-top">
            <div class="logo">
                <div class="logo-icon">P</div>
                <div class="logo-text">PromptRepo</div>
            </div>
            <div class="nav-section">
                <div class="nav-label">OVERVIEW</div>
                <a href="Dashboard.php" class="nav-item"><span class="icon">📊</span> Dashboard</a>
                <a href="categories.php" class="nav-item active"><span class="icon">📁</span> Categories</a>
                <a href="../prompts/index.php" class="nav-item"><span class="icon">📋</span> All Prompts</a>
            </div>
        </div>
        <div class="user-profile" style="background:#1E293B;border-color:#334155;">
            <div class="user-avatar" style="background:#EC4899;"><?= strtoupper(substr($_SESSION['username'], 0, 2)) ?></div>
            <div class="user-info">
                <div class="user-name"><?= $_SESSION['username'] ?></div>
                <div class="user-role">Admin</div>
            </div>
            <a href="../auth/logout.php" class="logout-btn" title="Logout">⎋</a>
        </div>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div>
                <h1 class="page-title">Manage Categories</h1>
                <p class="page-subtitle">Add, edit or remove prompt categories</p>
            </div>
        </div>

        <!-- Formulaire d'ajout -->
        <div class="form-container" style="max-width:100%;">
            <div class="form-card">
                <h2 style="font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:600;margin-bottom:16px;color:var(--text-primary);">Add New Category</h2>
                <form method="POST" style="display:flex;gap:12px;align-items:flex-end;">
                    <div class="form-group" style="flex:1;margin-bottom:0;">
                        <label>Category Name</label>
                        <input type="text" name="title" placeholder="e.g. DevOps, Testing..." required>
                    </div>
                    <button type="submit" name="add" class="btn-primary" style="height:42px;">+ Add</button>
                </form>
            </div>
        </div>

        <!-- Liste des catégories -->
        <div class="form-container" style="max-width:100%;">
            <div class="form-card">
                <h2 style="font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:600;margin-bottom:16px;color:var(--text-primary);">All Categories (<?= count($categories) ?>)</h2>

                <?php if (count($categories) > 0) : ?>
                <?php
                $colors = ['#00FF9C','#00D1FF','#F59E0B','#EC4899','#8B5CF6','#EF4444'];
                foreach ($categories as $i => $cat) :
                    $color = $colors[$i % count($colors)];
                ?>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--neutral-border);">
                    <div style="display:flex;gap:12px;align-items:center;flex:1;">
                        <span class="cat-dot" style="background:<?= $color ?>;"></span>
                        <span style="color:var(--text-primary);font-size:14px;flex:1;"><?= $cat['Title'] ?></span>
                    </div>
                    <a href="categories.php?delete=<?= $cat['Id'] ?>"
                       onclick="return confirm('Delete this category?')"
                       style="color:#F87171;background:rgba(239,68,68,0.1);padding:6px 14px;border-radius:6px;font-size:13px;margin-left:8px;">Delete</a>
                </div>
                <?php endforeach; ?>
                <?php else : ?>
                <div class="empty-state">
                    <p>No categories yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
</body>
</html>