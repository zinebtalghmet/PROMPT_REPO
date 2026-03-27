<?php
session_start();
include '../config/Database.php';
include '../classes/Prompt.php';
include '../classes/Category.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$database = new Database();
$db = $database->connect();

$prompt = new Prompt($db);
$category = new Category($db);

// Jib les catégories l le filtre
$categories = $category->getAll()->fetchAll(PDO::FETCH_ASSOC);

// Jib les prompts (avec filtre ila kayn)
if (isset($_GET['category']) && $_GET['category'] != '') {
    $prompts = $prompt->getByCategory($_GET['category'])->fetchAll(PDO::FETCH_ASSOC);
} else {
    $prompts = $prompt->getAll()->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Prompts - PromptRepo</title>
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
                <a href="index.php" class="nav-item active"><span class="icon">📋</span> My Prompts</a>
                <a href="create.php" class="nav-item"><span class="icon">➕</span> Add Prompt</a>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="../admin/Dashboard.php" class="nav-item"><span class="icon">📊</span> Dashboard</a>
                <?php endif; ?>
            </div>

            <div class="cat-section">
                <div class="nav-label">CATEGORIES</div>
                <?php
                $catColors = ['#6366F1','#EC4899','#F59E0B','#10B981','#3B82F6','#EF4444'];
                foreach ($categories as $i => $c) :
                    $color = $catColors[$i % count($catColors)];
                ?>
                <a href="index.php?category=<?= $c['Id'] ?>" class="cat-item">
                    <span><span class="cat-dot" style="background:<?= $color ?>"></span><?= $c['Title'] ?></span>
                </a>
                <?php endforeach; ?>
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
                <h1 class="page-title">My Prompts</h1>
                <p class="page-subtitle">Manage and organize your tested prompt collection</p>
            </div>
            <div class="top-actions">
                <a href="create.php" class="btn-primary">+ New Prompt</a>
                <a href="../auth/logout.php" class="btn-secondary">Logout</a>
            </div>
        </div>

        <!-- Filter Row -->
        <div class="filter-row">
            <a href="index.php" class="filter-btn <?= !isset($_GET['category']) ? 'active' : '' ?>">All</a>
            <?php foreach ($categories as $c) : ?>
            <a href="index.php?category=<?= $c['Id'] ?>" class="filter-btn <?= (isset($_GET['category']) && $_GET['category'] == $c['Id']) ? 'active' : '' ?>"><?= $c['Title'] ?></a>
            <?php endforeach; ?>
        </div>

        <!-- Prompt Cards -->
        <?php if (count($prompts) > 0) : ?>
        <div class="cards-grid">
            <?php foreach ($prompts as $p) :
                $catLower = strtolower($p['Category_Title']);
                $tagClass = 'tag-default';
                if (strpos($catLower, 'code') !== false) $tagClass = 'tag-code';
                elseif (strpos($catLower, 'sql') !== false) $tagClass = 'tag-sql';
                elseif (strpos($catLower, 'market') !== false) $tagClass = 'tag-marketing';
                elseif (strpos($catLower, 'devops') !== false) $tagClass = 'tag-devops';
            ?>
            <div class="prompt-card">
                <div class="card-tag <?= $tagClass ?>"><?= $p['Category_Title'] ?></div>
                <a href="view.php?id=<?= $p['Id'] ?>" class="card-title" style="color:var(--text-primary);"><?= $p['Title'] ?></a>
                <div class="card-content"><?= $p['content'] ?></div>
                <div class="card-footer">
                    <div>
                        <span class="card-meta"><?= date('M d, Y', strtotime($p['Created_at'])) ?></span>
                        <span class="card-author"><?= $p['Username'] ?></span>
                    </div>
                    <?php if ($p['User_Id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin') : ?>
                    <div class="card-actions">
                        <a href="edit.php?id=<?= $p['Id'] ?>" class="edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $p['Id'] ?>" onclick="return confirm('Delete this prompt?')" class="delete-btn">Delete</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="empty-state">
            <p>No prompts yet. Start building your collection!</p>
            <a href="create.php" class="btn-primary">+ Add your first prompt</a>
        </div>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
