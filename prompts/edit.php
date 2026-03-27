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

$categories = $category->getAll()->fetchAll(PDO::FETCH_ASSOC);

$prompt->id = $_GET['id'];
$stmt = $prompt->getById();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier wach had le prompt dial l'user wla admin
if (!$row || ($row['User_Id'] != $_SESSION['user_id'] && $_SESSION['role'] != 'admin')) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prompt->title       = $_POST['title'];
    $prompt->content     = $_POST['content'];
    $prompt->category_id = $_POST['category_id'];

    if ($prompt->update()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Erreur lors de la modification.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prompt - PromptRepo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="dashboard">
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
        </div>
        <div class="user-profile">
            <div class="user-avatar"><?= strtoupper(substr($_SESSION['username'], 0, 2)) ?></div>
            <div class="user-info">
                <div class="user-name"><?= $_SESSION['username'] ?></div>
                <div class="user-role"><?= $_SESSION['role'] == 'admin' ? 'Admin' : 'Developer' ?></div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div>
                <h1 class="page-title">Edit Prompt</h1>
                <p class="page-subtitle">Update your prompt details</p>
            </div>
        </div>

        <div class="form-container">
            <div class="form-card">
                <?php if (isset($error)) : ?>
                    <div class="error-msg"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?= $row['Title'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" rows="6" required><?= $row['content'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" required>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat['Id'] ?>" <?= $cat['Id'] == $row['Category_Id'] ? 'selected' : '' ?>><?= $cat['Title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Save Changes</button>
                        <a href="index.php" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
