<?php
session_start();
include "../config/Database.php";
include "../classes/User.php";

$database = new Database();
$db = $database->connect();

$user = new User($db);

if($_SERVER['REQUEST_METHOD']=="POST"){
    $user->email = $_POST['email'];
    $user->password =$_POST['password'];


    if($user->login()){

        $_SESSION['user_id'] =$user->id;
        $_SESSION['username']=$user->username;
        $_SESSION['role']=$user->role;

        header("Location:../index.php");
        exit;
    }else{
        $error = "Email ou mot de passe incorrect.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PromptRepo</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <div class="auth-container">
        <!-- Form Side -->
        <div class="form-side">
            <div class="logo">
                <div class="logo-icon">P</div>
                <div class="logo-text">PromptRepo</div>
            </div>

            <div class="form-header">
                <h1>Welcome back<br>to your <span>prompt library.</span></h1>
                <p>Sign in to access your curated collection of high-performing AI prompts.</p>
            </div>

            <?php if(isset($error)) : ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="you@devgenius.io" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                    <div class="form-link"><a href="#">Forgot password?</a></div>
                </div>

                <button type="submit" class="btn-submit">Sign In &rarr;</button>
            </form>

            <div class="form-footer">
                Don't have an account? <a href="registre.php">Create one</a>
            </div>
        </div>

        <!-- Dark Visual Panel -->
        <div class="visual-side">
            <div class="glow1"></div>
            <div class="glow2"></div>
            <div class="grid-lines">
                <div class="h-line" style="top:25%"></div>
                <div class="h-line" style="top:50%"></div>
                <div class="h-line" style="top:75%"></div>
                <div class="v-line" style="left:30%"></div>
                <div class="v-line" style="left:65%"></div>
            </div>

            <div class="stat-bubble bubble1">
                <div class="dot" style="background:#00E5A0"></div>
                <span>128 prompts saved</span>
            </div>
            <div class="stat-bubble bubble2">
                <div class="dot" style="background:#00D1FF"></div>
                <span>24 developers</span>
            </div>
            <div class="stat-bubble bubble3">
                <div class="dot" style="background:#FBBF24"></div>
                <span>6 categories</span>
            </div>

            <div class="float-card card1">
                <div class="card-tag">Code Generation</div>
                <h3>React Hook Form Validator</h3>
                <p>Generate a complete form validation with custom hooks and error handling.</p>
                <div class="card-action">&#9889; Use prompt</div>
            </div>

            <div class="float-card card2">
                <div class="card-tag">SQL &amp; Database</div>
                <h3>PostgreSQL Index Advisor</h3>
                <p>Analyze slow queries and generate optimal indexes to make queries run faster.</p>
                <div class="card-action">&#128203; Copy prompt</div>
            </div>

            <div class="brand-text">Built by DevGenius Solutions</div>
        </div>
    </div>
</body>
</html>