<!DOCTYPE html>
<html lang="en">
<head>
<script>
// Get the modal
var modal = document.getElementById("eventModal");

// Get the button that opens the modal
var btn = document.getElementById("createEventBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

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
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 400px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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


    <!-- Modal HTML -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <input type="text" name="event_date" placeholder="Event Date (YYYY-MM-DD)" required>
    <input type="text" name="event_address" placeholder="Event Address" required>
    <input type="number" name="event_capacity" placeholder="Attendance Capacity" required>
    <input type="number" name="event_tickets" placeholder="Tickets Available" required>
    <button class="button" type="submit" name="create_event">Create Event</button>
</form>



<?php if (!empty($bookDescription)): ?>
    <div class="description">
        <p><strong>Book Donation:</strong> <?php echo htmlspecialchars($bookDescription); ?></p>
    </div>
<?php endif; ?>

<?php if (!empty($clothesDescription)): ?>
    <div class="description">
        <p><strong>Clothes Donation:</strong> <?php echo htmlspecialchars($clothesDescription); ?></p>
    </div>
<?php endif; ?>

<?php if (!empty($moneyDescription)): ?>
    <div class="description">
        <p><strong>Money Donation:</strong> <?php echo htmlspecialchars($moneyDescription); ?></p>
    </div>
<?php endif; ?>

</div>
</body>
</html>
