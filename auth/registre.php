<?php
include '../config/Database.php';
include '../classes/User.php';

$database = new Database(); 
//connect() la methode new PDO
$db = $database->connect();

$user = new User($db);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $user->username = $_POST['username'];
    $user->email =$_POST['email'];
    $user->password = $_POST['password'];

    if($user->registre()){
        $success="Inscription réussie! Connectez-vous.";

    }else{
        $error = "Erreur lors de l'inscription.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - PromptRepo</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <div class="auth-container">
        <!-- Dark Visual Panel (left side for signup) -->
        <div class="visual-side">
            <div class="glow1" style="top:150px;left:50px"></div>
            <div class="glow2" style="top:500px;left:250px"></div>
            <div class="grid-lines">
                <div class="h-line" style="top:30%"></div>
                <div class="h-line" style="top:60%"></div>
                <div class="v-line" style="left:25%"></div>
                <div class="v-line" style="left:65%"></div>
            </div>

            <div class="logo" style="position:absolute;top:50px;left:50px;">
                <div class="logo-icon">P</div>
                <div class="logo-text" style="color:#F1F5F9;">PromptRepo</div>
            </div>

            <div class="float-card" style="width:500px;top:22%;left:8%;border-radius:20px;padding:32px 36px;">
                <p style="font-size:28px;color:#374151;line-height:1;margin-bottom:16px;">&ldquo;</p>
                <p style="color:#CBD5E1;font-size:15px;line-height:1.7;margin-bottom:20px;">
                    PromptRepo changed how our entire team works with AI. We went from losing our best prompts in
                    Slack threads to having a structured, searchable knowledge base. It's a game changer.
                </p>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;background:#00E5A0;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#0F172A;font-weight:700;">S</div>
                    <div>
                        <div style="color:#F1F5F9;font-size:14px;font-weight:600;">Sarah Martin</div>
                        <div style="color:#64748B;font-size:12px;">Lead Developer, DevGenius Solutions</div>
                    </div>
                </div>
            </div>

            <div class="stat-bubble" style="top:74%;left:8%;">
                <div class="dot" style="background:#00E5A0"></div>
                <span>Security default</span>
            </div>
            <div class="stat-bubble" style="top:74%;left:35%;">
                <div class="dot" style="background:#00D1FF"></div>
                <span>Setup in 2 min</span>
            </div>

            <div class="brand-text">Trusted by 24 developers at DevGenius Solutions</div>
        </div>

        <!-- Form Side -->
        <div class="form-side" style="width:53%;">
            <div class="form-header">
                <h1>Create your account<br>and start <span>building.</span></h1>
                <p>Join your team's AI knowledge base in under 2 minutes.</p>
            </div>

            <?php if (isset($success)) : ?>
                <div class="success-msg"><?= $success ?></div>
            <?php endif; ?>

            <?php if (isset($error)) : ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="johndoe" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="you@devgenius.io" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 6 characters" required>
                </div>

                <button type="submit" class="btn-submit">Create Account &rarr;</button>
            </form>

            <div class="form-footer">
                Already have an account? <a href="login.php">Sign in</a>
            </div>
        </div>
    </div>
</body>
</html>