<?php
include('../includes/db.php');  // Include the database connection
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: ../index.php"); // Redirect to the main page
        exit();
    } else {
        // Invalid login
        $error_message = "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Mini E-commerce</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f5f5f4;
    padding: 25px;
}

/* Main Container */

.login-wrapper {
    width: 100%;
    max-width: 1000px;
    min-height: 590px;
    display: flex;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.10);
}

/* Left Panel */

.login-banner {
    flex: 1;
    background: linear-gradient(145deg, #f97316, #ea580c);
    padding: 55px 45px;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.login-banner::before {
    content: "";
    position: absolute;
    width: 350px;
    height: 350px;
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 50%;
    top: -130px;
    right: -130px;
}

.login-banner::after {
    content: "";
    position: absolute;
    width: 280px;
    height: 280px;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 50%;
    bottom: -100px;
    left: -100px;
}

.brand {
    font-size: 25px;
    font-weight: 750;
    letter-spacing: -0.5px;
    position: relative;
    z-index: 1;
}

.brand span {
    color: #ffedd5;
}

.banner-content {
    position: relative;
    z-index: 1;
}

.banner-content h1 {
    font-size: 38px;
    line-height: 1.3;
    margin-bottom: 20px;
    font-weight: 700;
}

.banner-content p {
    color: #ffedd5;
    font-size: 15px;
    line-height: 1.8;
    max-width: 340px;
}

.banner-decoration {
    position: relative;
    z-index: 1;
    margin-top: 30px;
    font-size: 85px;
    text-align: center;
    opacity: 0.95;
}

.banner-footer {
    position: relative;
    z-index: 1;
    font-size: 12px;
    color: #ffedd5;
}

/* Right Login Section */

.login-form-section {
    flex: 1;
    padding: 65px 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-heading {
    margin-bottom: 38px;
}

.login-heading .tag {
    display: inline-block;
    background: #fff1e6;
    color: #ea580c;
    padding: 7px 13px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 20px;
}

.login-heading h2 {
    font-size: 32px;
    color: #1f2937;
    margin-bottom: 10px;
    font-weight: 700;
}

.login-heading p {
    color: #8b929c;
    font-size: 14px;
    line-height: 1.6;
}

/* Input Fields */

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 10px;
}

.input-wrapper {
    position: relative;
}

.input-wrapper .icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #a1a1aa;
    font-size: 17px;
}

.input-wrapper input {
    width: 100%;
    height: 53px;
    padding: 0 15px 0 47px;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    outline: none;
    font-size: 14px;
    color: #374151;
    background: #fafafa;
    transition: all 0.3s ease;
}

.input-wrapper input::placeholder {
    color: #a1a1aa;
}

.input-wrapper input:focus {
    border-color: #f97316;
    background: white;
    box-shadow: 0 0 0 4px rgba(249,115,22,0.10);
}

/* Button */

.login-btn {
    width: 100%;
    height: 53px;
    border: none;
    border-radius: 9px;
    background: #f97316;
    color: white;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
    transition: all 0.3s ease;
}

.login-btn:hover {
    background: #ea580c;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(249,115,22,0.22);
}

.login-btn:active {
    transform: translateY(0);
}

/* Error Message */

.error-message {
    color: #dc2626;
    background: #fef2f2;
    border: 1px solid #fecaca;
    padding: 12px;
    border-radius: 8px;
    font-size: 13px;
    text-align: center;
    margin-top: 20px;
}

/* Footer */

.login-footer {
    margin-top: 35px;
    padding-top: 20px;
    border-top: 1px solid #f1f1f1;
    text-align: center;
    color: #9ca3af;
    font-size: 12px;
}

/* Responsive */

@media(max-width: 768px) {
    .login-wrapper {
        max-width: 460px;
        min-height: auto;
    }

    .login-banner {
        display: none;
    }

    .login-form-section {
        padding: 50px 35px;
    }
}

@media(max-width: 480px) {
    body {
        padding: 12px;
    }

    .login-form-section {
        padding: 40px 23px;
    }

    .login-heading h2 {
        font-size: 28px;
    }
}
</style>
</head>

<body>

<div class="login-wrapper">

    <!-- Left Banner -->

    <div class="login-banner">

        <div class="brand">
            ORANGE<span>Store.</span>
        </div>

        <div class="banner-content">
            <h1>Shopping<br>Made Simple.</h1>

            <p>
                Your favorite products are just a step away.
                Sign in to access your account and continue
                enjoying a seamless shopping experience.
            </p>

            <div class="banner-decoration">🛍️</div>
        </div>

        <div class="banner-footer">
            Your shopping destination.
        </div>

    </div>

    <!-- Login Form -->

    <div class="login-form-section">

        <div class="login-heading">

            <span class="tag">ACCOUNT LOGIN</span>

            <h2>Welcome Back!</h2>

            <p>
                Please enter your registered credentials
                to access your account.
            </p>

        </div>

        <form method="POST">

            <div class="form-group">

                <label for="email">Email Address</label>

                <div class="input-wrapper">
                    <span class="icon">✉</span>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your registered email"
                        required
                    >
                </div>

            </div>

            <div class="form-group">

                <label for="password">Password</label>

                <div class="input-wrapper">
                    <span class="icon">🔒</span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                </div>

            </div>

            <button
                type="submit"
                name="login"
                class="login-btn"
            >
                Sign In →
            </button>

        </form>

        <?php if (isset($error_message)): ?>
            <p class="error-message">
                <?= htmlspecialchars($error_message); ?>
            </p>
        <?php endif; ?>

        <div class="login-footer">
            © 2026 MiniShop. All rights reserved.
        </div>

    </div>

</div>

</body>
</html>