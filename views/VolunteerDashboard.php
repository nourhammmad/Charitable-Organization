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
<div class="donation-options">
<div class="option" onclick="viewNotifications()">
        <div class="option-icon">🔔</div>
        <a>View Notifications</a>
    </div>
</div>

<div id="notificationsModal" style="display: none; position: fixed; top: 20%; left: 30%; width: 40%; background: #fff; border: 1px solid #ccc; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); padding: 20px; z-index: 1000;">
<span class="close-button" style="position: absolute; top: 10px; right: 10px; cursor: pointer; font-size: 20px;">&times;</span>
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Notifications</h2>
        <ul id="notification-list">
            <!-- Notifications will be dynamically added here -->
        </ul>
    </div>
</div>

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
function viewNotifications() {
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('user_id');
    if (!userId) {
        alert("user ID is missing.");
        return;
    }

   
    const formData = new FormData();
    formData.append('action', 'view_notifications');
    formData.append('userId', userId);

    fetch("../controllers/DonationController.php", {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())  
    .then(rawData => {
        try {
            alert(rawData);
            const data = JSON.parse(rawData);  
            if (data.success) {
                alert("da5alt");
                alert(data.notifications);
                displayNotifications(data.notifications); 
            } else {
                alert(data.message || 'Error fetching notifications.');
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
            alert("Invalid JSON format.");
        }
    })
    .catch(error => {
        console.error('Error fetching notifications:', error);
        alert('An error occurred while fetching notifications.');
    });
}

function displayNotifications(notifications) {
    const notificationsModal = document.getElementById("notificationsModal");
    const notificationList = document.getElementById("notification-list");

   
    notificationList.innerHTML = '';
    alert (notifications);
    alert(notifications.length);
    
    if (notifications && notifications.length > 0) {
        alert("goa el if");
        notifications.forEach(notification => {
            const li = document.createElement('li');
            
            li.textContent = `${notification.senderName}: ${notification.message  || 'No message available'} : ${notification.createdAt}`;
            
            notificationList.appendChild(li);
        });
    } else {
        const li = document.createElement('li');
        li.textContent = 'No notifications found.';
        notificationList.appendChild(li);
    }

    notificationsModal.style.display = 'block';

    const closeButton = notificationsModal.querySelector(".close-button");
    if (closeButton) {
        console.log("Close button found"); 
        closeButton.addEventListener("click", () => {
            notificationsModal.style.display = 'none';
        });
    } else {
        console.error("Close button not found");
    }
}


</script>



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