<?php
// Ensure variables are defined
session_start();
$volunteerId = $_GET['volunteer_id'];  // Example of a logged-in volunteer
$events = $_SESSION['volunteer_events'] ?? [];
$tasks = $_SESSION['volunteer_tasks'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
        }
        h1 {
            font-size: 2.5rem;
            color: #4CAF50;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 50px;
        }
        p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #666;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #ffffff;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        button {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:disabled {
            background-color: #d3d3d3;
            cursor: not-allowed;
        }
        button:hover:not(:disabled) {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h1>Available Volunteer Events</h1>
<?php if (is_array($events) && !empty($events)): ?>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                Event Name: <?= $event['eventName'] ?> | Date: <?= $event['date'] ?>
                <button id="applyButton<?= $event['eventId'] ?>" onclick="applyForEvent(<?= $event['eventId'] ?>, this)">Apply</button>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No events available at the moment.</p>
<?php endif; ?>
<h1>Available Volunteer Tasks</h1>
<?php if (is_array($tasks) && !empty($tasks)): ?>
    <ul>
        <?php foreach ($tasks as $tasks): ?>
            <li>
                Task Name: <?= $tasks['name'] ?> | Description: <?= $tasks['description'] ?>
                <button id="applyButton<?= $tasks['id'] ?>" onclick="applyForTasks(<?= $tasks['id'] ?>, this)">Apply</button>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tasks available at the moment.</p>
<?php endif; ?>
<script>
    // JavaScript function to handle applying for an event
    function applyForEvent(eventId, button) {
        const volunteerId = <?= $volunteerId; ?>;
        const formData = new FormData();
        formData.append('volunteerId', volunteerId);
        formData.append('eventId', eventId);

        const documentRoot = '/controllers/VolunteerEventHandlerController.php';  // Use relative URL instead of document root

        fetch(documentRoot, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);  // Show success or failure message from the server
            button.innerText = "Applied";  // Change button text
            button.disabled = true;  // Disable the button to prevent further clicks
        })
        .catch(error => console.error('Error:', error));
    }
    function applyForTasks(id, button) {
        const volunteerId = <?= $volunteerId; ?>;
        const formData = new FormData();
        formData.append('volunteerId', volunteerId);
        formData.append('id', id);

        const documentRoot = '../controllers/VolunteerEventHandlerController.php';  

        fetch(documentRoot, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);  // Show success or failure message from the server
            button.innerText = "Applied";  // Change button text
            button.disabled = true;  // Disable the button to prevent further clicks
        })
        .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>