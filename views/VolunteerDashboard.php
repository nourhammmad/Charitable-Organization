<?php
$volunteerId = isset($_GET['volunteer_id']) ? $_GET['volunteer_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        h1 {
            font-size: 2.5rem;
            color: #4CAF50;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 50px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
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
        .fetch-button {
            padding: 25px 50px;
            font-size: 2rem;
            margin: 20px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .fetch-button:hover {
            background-color: #45a049;
        }
        ul {
            list-style-type: none;
            padding: 0;
            text-align: left;
        }
        li {
            background-color: #ffffff;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .no-content {
            font-size: 1.5rem;
            color: #ff6347;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);

        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
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
        #volunteerNotificationsModal {
         display: none;
}


        
    </style>
</head>
<body>

<h1>Volunteer Dashboard</h1>
<div class="option" onclick="viewNotifications()">
        <div class="option-icon">🔔</div>
        <a>View Notifications</a>
    </div>
</div>
<div class="button-container">
    <button class="fetch-button" onclick="fetchEvents()">View Events🎉</button>
    <button class="fetch-button" onclick="fetchTasks()">View Tasks📝</button>
    <button class="fetch-button" onclick="openVolunteerNotificationsModal()">New Events 🔔</button>

</div>

<!-- Notifications Modal -->
<div id="notificationsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('notificationsModal')">&times;</span>
        <h2>New Notifications</h2>
        <ul id="notification-list"></ul>
    </div>
</div>
<!-- Volunteer Notifications Modal -->

<div id="volunteerNotificationsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('volunteerNotificationsModal')">&times;</span>
        <h2>Volunteer Notifications</h2>
        <ul id="volunteerNotification-list"></ul>
    </div>
</div>



<!-- Modal for event details -->
<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('eventModal')">&times;</span>
        <h2 id="eventTitle"></h2>
        <p id="eventDetails"></p>
    </div>
</div>

<!-- Modal for task details -->
<div id="taskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('taskModal')">&times;</span>
        <h2 id="taskTitle"></h2>
        <p id="taskDetails"></p>
    </div>
</div>


</div>

<script>
    // userId=1;
    function openVolunteerNotificationsModal() {
    // Replace with actual user ID retrieval

    const userId = new URLSearchParams(window.location.search).get('user_id');
    
    if (!userId) {
        alert("User ID is missing.");
        return;
    }

    const formData = new FormData();
    formData.append('action', 'view_notifications');
    formData.append('userId', userId);
    alert(userId);
    fetch("../Services/volunteerRoute.php", {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(rawData => {
        alert("Raw server response:", rawData);  // Log the raw response
        try {
            const data = JSON.parse(rawData);  // Parse the JSON response
            if (data.success) {
                displayVolunteerNotifications(data.notifications);
            } else {
                alert(data.message || 'Error fetching notifications.');
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
            alert("Invalid JSON format. Check the server response.");
        }
    })
    .catch(error => {
        console.error("Error fetching notifications:", error);
        alert("An error occurred while fetching notifications.");
    });
}

function displayVolunteerNotifications(notifications) {
    const notificationList = document.getElementById("volunteerNotification-list");
    notificationList.innerHTML = ''; // Clear previous notifications

    if (notifications && notifications.length > 0) {
        notifications.forEach(notification => {
            const li = document.createElement('li');
            li.innerHTML = `${notification}`;
            notificationList.appendChild(li);
        });
    } else {
        const li = document.createElement('li');
        li.textContent = 'No notifications found.';
        notificationList.appendChild(li);
    }

    // Show the modal
    document.getElementById("volunteerNotificationsModal").style.display = 'block';
}



function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}


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
           
            const data = JSON.parse(rawData);  
            if (data.success) {
              
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
    // alert (notifications);
    // alert(notifications.length);
    
    if (notifications && notifications.length > 0) {
       
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

function fetchEvents() {
    // Hide tasks section if it's displayed
    document.getElementById('tasks-list').style.display = "none";
    document.getElementById('no-tasks-message').style.display = "none";

    // Show events section
    document.getElementById('events-list').style.display = "block";
    document.getElementById('no-events-message').style.display = "block";

    fetch('../controllers/VolunteerEventHandlerController.php?action=getEvents&volunteer_id=<?= $volunteerId; ?>')
        .then(response => response.json())
        .then(data => {
            const eventsList = document.getElementById('events-list');
            const message = document.getElementById('no-events-message');
            eventsList.innerHTML = '';
            message.innerHTML = ''; // Clear any previous message

            if (data.events.length === 0) {
                message.innerHTML = 'No events available';
            } else {
                data.events.forEach(event => {
                    const li = document.createElement('li');
                    const isApplied = event.isApplied; // Assuming the event data contains an 'isApplied' field
                    li.innerHTML = `🎉 ${event.eventName} | Date: ${event.date}`;

                    // Apply button
                    const applyButton = document.createElement('button');
                    applyButton.id = `applyButton${event.eventId}`;
                    applyButton.innerText = isApplied ? 'Applied' : 'Apply';
                    applyButton.disabled = isApplied;
                    applyButton.style.backgroundColor = isApplied ? 'grey' : '#4CAF50';
                    applyButton.style.color = isApplied ? 'white' : 'black';
                    applyButton.onclick = () => applyForEvent(event.eventId, applyButton);

                    // Append apply button to the list item
                    li.appendChild(applyButton);
                    eventsList.appendChild(li);
                });
            }
        })
        .catch(error => console.error('Error fetching events:', error));
}

function fetchTasks() {
    // Hide events section if it's displayed
    document.getElementById('events-list').style.display = "none";
    document.getElementById('no-events-message').style.display = "none";

    // Show tasks section
    document.getElementById('tasks-list').style.display = "block";
    document.getElementById('no-tasks-message').style.display = "block";

    fetch('../controllers/VolunteerEventHandlerController.php?action=getTasks&volunteer_id=<?= $volunteerId; ?>')
        .then(response => response.json())
        .then(data => {
            const tasksList = document.getElementById('tasks-list');
            const message = document.getElementById('no-tasks-message');
            tasksList.innerHTML = '';
            message.innerHTML = ''; // Clear any previous message

            if (data.tasks.length === 0) {
                message.innerHTML = 'No tasks available';
            } else {
                data.tasks.forEach(task => {
                    const li = document.createElement('li');
                    const isApplied = task.isApplied; // Assuming the task data contains an 'isApplied' field
                    li.innerHTML = `📝 ${task.name} | Description: ${task.description}`;

                    // Apply button
                    const applyButton = document.createElement('button');
                    applyButton.id = `applyButton${task.taskId}`;
                    applyButton.innerText = isApplied ? 'Applied' : 'Apply';
                    applyButton.disabled = isApplied;
                    applyButton.style.backgroundColor = isApplied ? 'grey' : '#4CAF50';
                    applyButton.style.color = isApplied ? 'white' : 'black';
                    applyButton.onclick = () => applyForTasks(task.id, applyButton);

                    // Append apply button to the list item
                    li.appendChild(applyButton);
                    tasksList.appendChild(li);
                });
            }
        })
        .catch(error => console.error('Error fetching tasks:', error));
}

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
     
        button.innerText = "Applied";  // Change button text
        button.disabled = true;  // Disable the button to prevent further clicks
        button.style.backgroundColor = 'grey';  // Change button color
        button.style.color = 'white';  // Change text color
    })
    .catch(error => console.error('Error:', error));
}

function applyForTasks(taskId, button) {
    const volunteerId   = <?= $volunteerId; ?>;
    const formData = new FormData();
    formData.append('volunteerId', volunteerId);
    formData.append('taskId', taskId);

    const documentRoot = '../controllers/VolunteerEventHandlerController.php';  

    fetch(documentRoot, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        
        button.innerText = "Applied";  // Change button text
        button.disabled = true;  // Disable the button to prevent further clicks
        button.style.backgroundColor = 'grey';  // Change button color
        button.style.color = 'white';  // Change text color
    })
    .catch(error => console.error('Error:', error));
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}
</script>

<!-- Section for Events -->
<h2>Events</h2>
<ul id="events-list" style="display: none;"></ul>
<p id="no-events-message" class="no-content" style="display: none;"></p>

<!-- Section for Tasks -->
<h2>Tasks</h2>
<ul id="tasks-list" style="display: none;"></ul>
<p id="no-tasks-message" class="no-content" style="display: none;"></p>

</body>
</html>
