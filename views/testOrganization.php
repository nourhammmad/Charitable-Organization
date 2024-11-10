<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Organization</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            color: #4CAF50;
        }
        .message {
            margin-top: 20px;
            color: green;
        }
        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Test Organization Controller</h2>
    
    <!-- Form to fetch organization data -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <button type="submit" name="get_registered_org">Get Organization</button>
    </form>

    <!-- Form to fetch donors data -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="margin-top: 10px;">
        <button type="submit" name="get_donors">Get Donors</button>
    </form>

 
</div>

</body>
</html>
