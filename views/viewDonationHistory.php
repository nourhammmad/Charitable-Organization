<!-- views/donationHistoryView.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation History</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Donation History</h1>
    <table>
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>Donation Type</th>
                <th>Date</th>
                <th>Amount / Item</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donationHistory as $donation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($donation['id']); ?></td>
                    <td><?php echo htmlspecialchars($donation['type']); ?></td>
                    <td><?php echo htmlspecialchars($donation['date']); ?></td>
                    <td><?php echo htmlspecialchars($donation['amount'] ?? $donation['item']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php">Back to Home</a>
</body>
</html>