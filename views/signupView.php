<!-- signupView.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
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
        }
        button:hover {
            background: #45a049;
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
        <h2>Sign Up</h2>
        <?php if (isset($signup_error)) echo "<p class='error'>$signup_error</p>"; ?>
        <form method="post">
            <input type="email" name="signup_email" placeholder="Email" required>
            <input type="text" name="signup_userName" placeholder="Username" required>
            <input type="password" name="signup_password" placeholder="Password" required>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Org">Organization</option>
                <option value="Donar">Donor</option>
            </select>
            <button type="submit" name="signup">Sign Up</button>
        </form>
    </div>
</body>
</html>
