<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charitable Organization - Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
            color: #333;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .event-list {
            width: 80%;
            max-width: 800px;
            margin-top: 20px;
        }
        .event-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .event-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .event-details {
            max-width: 70%;
        }
        .event-details h2 {
            margin: 0 0 10px;
            font-size: 1.5rem;
            color: #333;
        }
        .event-details p {
            margin: 5px 0;
            color: #666;
        }
        .join-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .join-btn:hover {
            background-color: #45a049;
        }
        .no-events {
            font-size: 1.5rem;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Volunteer for Events</h1>
    <p>Select an event to join and make an impact.</p>

    <div class="event-list">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event-item">
                    <div class="event-details">
                        <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                        <p>Date: <?php echo htmlspecialchars($event['date']); ?></p>
                        <p>Location: <?php echo htmlspecialchars($event['location']); ?></p>
                        <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
                    </div>
                    <button class="join-btn" onclick="joinEvent(<?php echo htmlspecialchars($event['id']); ?>)">Join</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-events">No events available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>

    <script>
        function joinEvent(eventId) {
            const formData = new URLSearchParams();
            formData.append("eventId", eventId);
            formData.append("volunteerId", "<?php echo htmlspecialchars($volunteerId); ?>");
            $server=$_SERVER['DOCUMENT_ROOT'];
            fetch("./controllers/VolunteerCotroller.php", {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                // Optionally, refresh the page or update the UI
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
