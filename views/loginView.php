<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #45a049;
        }
        .social-login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            margin-top: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .google-btn {
            background: #db4437;
        }
        .facebook-btn {
            background: #4267B2;
        }
        .google-btn:hover {
            background: #c33d2e;
        }
        .facebook-btn:hover {
            background: #365899;
        }
        .error, .success {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <!-- Social Login Buttons -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <button type="submit" name="google_login" class="social-login-btn google-btn">Login with Google</button>
            <button type="submit" name="facebook_login" class="social-login-btn facebook-btn">Login with Facebook</button>
        </form>
        
        <h2>Sign Up</h2>
        <?php if (isset($signup_success)) echo "<p class='success'>$signup_success</p>"; ?>
        <?php if (isset($signup_error)) echo "<p class='error'>$signup_error</p>"; ?>
        <form method="post">
            <input type="email" name="signup_email" placeholder="Email" required>
            <input type="text" name="signup_userName" placeholder="Username" required>
            <input type="password" name="signup_password" placeholder="Password" required>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Volunteer">Volunteer</option>
                <option value="Donor">Donor</option>
            </select>
            <button type="submit" name="signup">Sign Up</button>
        </form>

        <h2>Or Login as Guest</h2>
        <form method="post">
            <button type="submit" name="guest">Continue as Guest</button>
        </form>
    </div>
</body>
</html>
