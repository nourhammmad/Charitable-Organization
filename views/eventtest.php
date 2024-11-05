<?php
//require_once ('E:\brwana\Gam3a\Senoir 2\Design Patterns\Project\Charitable-Organization\models\EventModel.php');

$event = new Event();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        // Create a new event
        $date = $_POST['date'];
        $address = $_POST['address'];
        $capacity = $_POST['capacity'];
        $event->createEvent($date, $address, $capacity);
    } elseif (isset($_POST['update'])) {
        // Update an existing event
        $eventId = $_POST['eventId'];
        $date = $_POST['date'];
        $address = $_POST['address'];
        $capacity = $_POST['capacity'];
        $event->updateEvent($eventId, $date, $address, $capacity);
    } elseif (isset($_POST['delete'])) {
        // Delete an event
        $eventId = $_POST['eventId'];
        $event->deleteEvent($eventId);
    }
}

// Retrieve all events to display
$events = $event->getAllEvents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
</head>
<body>
    <h1>Event Management</h1>

    <h2>Create New Event</h2>
    <form method="POST">
        <input type="date" name="date" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="number" name="capacity" placeholder="Capacity" required>
        <button type="submit" name="create">Create Event</button>
    </form>

    <h2>All Events</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Date</th>
                <th>Address</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $ev): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ev['eventId']); ?></td>
                    <td><?php echo htmlspecialchars($ev['date']); ?></td>
                    <td><?php echo htmlspecialchars($ev['address']); ?></td>
                    <td><?php echo htmlspecialchars($ev['EventAttendanceCapacity']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($ev['eventId']); ?>">
                            <input type="date" name="date" value="<?php echo htmlspecialchars($ev['date']); ?>" required>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($ev['address']); ?>" required>
                            <input type="number" name="capacity" value="<?php echo htmlspecialchars($ev['EventAttendanceCapacity']); ?>" required>
                            <button type="submit" name="update">Update</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($ev['eventId']); ?>">
                            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this event?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
