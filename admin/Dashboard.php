<?php
session_start();

include '../config/Database.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location:../auth/login.php");
    exit;
}

$database=new Database();
$db = $database->connect();

//total prompts
$stmt=$db->query("SELECT COUNT(*) as total FROM Prompts");
$totalPrompts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

//total users
$stmt=$db->query("SELECT COUNT(*) as total FROM Users");
$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

//total categories
$stmt=$db->query("SELECT COUNT(*) as total FROM Categories");
$totalCategories=$stmt->fetch(PDO::FETCH_ASSOC)['total'];

//top contributeurs
$stmt=$db->query("SELECT Users.Username, Users.Role, COUNT(Prompts.Id) as prompt_count
    FROM Prompts
    INNER JOIN Users ON Prompts.User_Id = Users.Id
    GROUP BY Users.Id
    ORDER BY prompt_count DESC
    LIMIT 5");
$topContributors=$stmt->fetchAll(PDO::FETCH_ASSOC);

//categories avec nombre de prompts
$stmt=$db->query("SELECT Categories.Title, COUNT(Prompts.Id) as prompt_count
    FROM Categories
    LEFT JOIN Prompts ON Categories.Id=Prompts.Category_Id
    GROUP BY Categories.Id
    ORDER BY prompt_count DESC");
$catStats=$stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PromptRepo</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .stat-card {
            background: var(--neutral-light);
            border: 1px solid var(--neutral-border);
            border-radius: 12px;
            padding: 24px;
        }
        .stat-label { font-size: 13px; color: var(--text-muted); margin-bottom: 8px; }
        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -1px;
        }
        .bottom-section { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .panel {
            background: var(--neutral-light);
            border: 1px solid var(--neutral-border);
            border-radius: 12px;
            padding: 24px;
        }
        .panel-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 20px;
        }
        .contrib-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--neutral-border);
        }
        .contrib-item:last-child { border-bottom: none; }
        .contrib-left { display: flex; align-items: center; gap: 12px; }
        .contrib-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; color: var(--neutral);
        }
        .contrib-name { font-size: 14px; font-weight: 500; color: var(--text-primary); }
        .contrib-role { font-size: 12px; color: var(--text-muted); }
        .contrib-count {
            background: rgba(0,255,156,0.1);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .cat-stat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--neutral-border);
        }
        .cat-stat-item:last-child { border-bottom: none; }
        .cat-stat-left { display: flex; align-items: center; gap: 10px; }
        .cat-stat-count { font-size: 13px; color: var(--text-muted); }
    </style>
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
                <a href="Dashboard.php" class="nav-item active"><span class="icon">📊</span> Dashboard</a>
                <a href="categories.php" class="nav-item"><span class="icon">📁</span> Categories</a>
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
                <h1 class="page-title">Admin Dashboard</h1>
                <p class="page-subtitle">Monitor platform activity and manage categories</p>
            </div>
            <a href="categories.php" class="btn-primary">+ New Category</a>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Prompts</div>
                <div class="stat-value"><?= $totalPrompts ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Users</div>
                <div class="stat-value"><?= $totalUsers ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Categories</div>
                <div class="stat-value"><?= $totalCategories ?></div>
            </div>
        </div>

        <!-- Bottom: Contributors + Categories -->
        <div class="bottom-section">
            <!-- Top Contributors -->
            <div class="panel">
                <div class="panel-title">Top Contributors</div>
                <?php
                $avatarColors = ['#00FF9C','#00D1FF','#F59E0B','#EC4899','#8B5CF6'];
                foreach ($topContributors as $i => $contrib) :
                    $color = $avatarColors[$i % count($avatarColors)];
                ?>
                <div class="contrib-item">
                    <div class="contrib-left">
                        <div class="contrib-avatar" style="background:<?= $color ?>;"><?= strtoupper(substr($contrib['Username'], 0, 2)) ?></div>
                        <div>
                            <div class="contrib-name"><?= $contrib['Username'] ?></div>
                            <div class="contrib-role"><?= ucfirst($contrib['Role']) ?></div>
                        </div>
                    </div>
                    <div class="contrib-count"><?= $contrib['prompt_count'] ?></div>
                </div>
                <?php endforeach; ?>
                <?php if (count($topContributors) == 0) : ?>
                <div class="empty-state"><p>No contributors yet.</p></div>
                <?php endif; ?>
            </div>

            <!-- Categories Stats -->
            <div class="panel">
                <div class="panel-title">Manage Categories</div>
                <?php
                $catColors = ['#00FF9C','#00D1FF','#F59E0B','#EC4899','#8B5CF6','#EF4444'];
                foreach ($catStats as $i => $cs) :
                    $color = $catColors[$i % count($catColors)];
                ?>
                <div class="cat-stat-item">
                    <div class="cat-stat-left">
                        <span class="cat-dot" style="background:<?= $color ?>;"></span>
                        <span style="color:var(--text-primary);font-size:14px;"><?= $cs['Title'] ?></span>
                    </div>
                    <span class="cat-stat-count"><?= $cs['prompt_count'] ?> prompts</span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</div>
</body>
</html>
