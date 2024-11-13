<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Organization</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h2 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        .button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #2980b9;
        }
        .description {
            margin-top: 20px;
            background-color: #ecf0f1;
            padding: 12px;
            border-radius: 8px;
            color: #2c3e50;
            font-size: 1.1rem;
            text-align: left;
        }
        .clear-button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .clear-button:hover {
            background-color: #c0392b;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Donation Tracking</h2>

    <!-- Button to fetch organization data -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <button class="button" type="submit" name="get_org">Get Organization</button>
    </form>

    <!-- Button to fetch donors data -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <button class="button" type="submit" name="get_donors">Get Donors</button>
    </form>

    <!-- Buttons to track different donation types -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <button class="button" type="submit" name="track_books">View Book Donation Description</button>
        <button class="button" type="submit" name="track_clothes">Track Clothes Donations</button>
        <button class="button" type="submit" name="track_money">Track Money Donations</button>
        <button class="clear-button" type="submit" name="clear">Clear Description</button>
    </form>

    <!-- Display donation descriptions -->
    <?php if (isset($bookDescription)): ?>
        <div class="description">
            <p><strong>Book Donation:</strong> <?php echo htmlspecialchars($bookDescription); ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($clothesDescription)): ?>
        <div class="description">
            <p><strong>Clothes Donation:</strong> <?php echo htmlspecialchars($clothesDescription); ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($moneyDescription)): ?>
        <div class="description">
            <p><strong>Money Donation:</strong> <?php echo htmlspecialchars($moneyDescription); ?></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>