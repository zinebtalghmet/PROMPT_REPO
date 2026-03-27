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

// Jib le prompt b INNER JOIN bach njibo smiya dial user + catégorie
$stmt = $db->prepare("SELECT Prompts.*, Users.Username, Categories.Title AS Category_Title
    FROM Prompts
    INNER JOIN Users ON Prompts.User_Id = Users.Id
    INNER JOIN Categories ON Prompts.Category_Id = Categories.Id
    WHERE Prompts.Id = :id");
$stmt->bindParam(":id", $prompt->id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header("Location: index.php");
    exit;
}

$catLower = strtolower($row['Category_Title']);
$tagClass = 'tag-default';
if (strpos($catLower, 'code') !== false) $tagClass = 'tag-code';
elseif (strpos($catLower, 'sql') !== false) $tagClass = 'tag-sql';
elseif (strpos($catLower, 'market') !== false) $tagClass = 'tag-marketing';
elseif (strpos($catLower, 'devops') !== false) $tagClass = 'tag-devops';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $row['Title'] ?> - PromptRepo</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .view-card {
            background: var(--neutral-light);
            border: 1px solid var(--neutral-border);
            border-radius: 12px;
            padding: 32px;
            max-width: 800px;
        }
        .view-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .view-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 12px;
        }
        .view-content {
            background: var(--neutral);
            border: 1px solid var(--neutral-border);
            border-radius: 8px;
            padding: 20px;
            font-size: 14px;
            line-height: 1.7;
            color: var(--text-secondary);
            white-space: pre-wrap;
            margin-bottom: 24px;
        }
        .view-meta {
            display: flex;
            align-items: center;
            gap: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--neutral-border);
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .meta-value { color: var(--text-primary); font-weight: 500; }
        .copy-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(0,255,156,0.1);
            color: var(--primary);
            border: 1px solid rgba(0,255,156,0.2);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
        }
        .copy-btn:hover { background: rgba(0,255,156,0.2); }
    </style>
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
                <h1 class="page-title">Prompt Details</h1>
                <p class="page-subtitle">View and copy this prompt</p>
            </div>
            <div class="top-actions">
                <a href="index.php" class="btn-secondary">← Back</a>
                <?php if ($row['User_Id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin') : ?>
                <a href="edit.php?id=<?= $row['Id'] ?>" class="btn-primary">Edit</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="view-card">
            <div class="view-header">
                <div>
                    <div class="card-tag <?= $tagClass ?>"><?= $row['Category_Title'] ?></div>
                    <div class="view-title"><?= $row['Title'] ?></div>
                </div>
                <button class="copy-btn" onclick="copyPrompt()">📋 Copy Prompt</button>
            </div>

            <div class="view-content" id="promptContent"><?= htmlspecialchars($row['content']) ?></div>

            <div class="view-meta">
                <div class="meta-item">Author: <span class="meta-value"><?= $row['Username'] ?></span></div>
                <div class="meta-item">Category: <span class="meta-value"><?= $row['Category_Title'] ?></span></div>
                <div class="meta-item">Date: <span class="meta-value"><?= date('M d, Y', strtotime($row['Created_at'])) ?></span></div>
            </div>
        </div>
    </main>
</div>

<script>
function copyPrompt() {
    var content = document.getElementById('promptContent').innerText;
    navigator.clipboard.writeText(content).then(function() {
        var btn = document.querySelector('.copy-btn');
        btn.innerHTML = '✅ Copied!';
        setTimeout(function() { btn.innerHTML = '📋 Copy Prompt'; }, 2000);
    });
}
</script>
</body>
</html>
