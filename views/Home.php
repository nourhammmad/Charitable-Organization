<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charitable Organization - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #666;
        }
        .donation-options {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }
        .option {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px 20px;
            width: 160px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .option:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            font-size: 1.2rem;
            display: inline-block;
            margin-top: 10px;
        }
        .option-icon {
            font-size: 2.5rem;
            color: #4CAF50;
        }
        .user-info {
            margin-top: 20px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <h1>Make a Difference Today</h1>
    <p>Choose a type of donation to help those in need</p>

    <div class="donation-options">
        <div class="option">
            <div class="option-icon">📚</div>
            <a href="donateBook.php">Donate Book</a>
        </div>
        <div class="option">
            <div class="option-icon">💰</div>
            <a href="donateMoney.php">Donate Money</a>
        </div>
        <div class="option">
            <div class="option-icon">👕</div>
            <a href="donateClothes.php">Donate Clothes</a>
        </div>
    </div>

    <div class="user-info">
        <p id="user-id-display">User ID: Not loaded</p>
        <button id="get-id-button">Get User ID</button>
    </div>

    <script>
        $path = './controllers/DonationDetails.php'
        document.getElementById("get-id-button").addEventListener("click", function () {
            fetch($path, {  
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "getid=true"
            })
            .then(response => response.text())  // Expect plain text response
            .then(data => {
                const display = document.getElementById("user-id-display");
                display.innerText = data;  // Display the response (User ID or error message)
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById("user-id-display").innerText = "An error occurred.";
            });
        });
    </script>
</body>
</html>
