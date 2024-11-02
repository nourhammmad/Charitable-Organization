<?php
require_once ('E:\brwana\Gam3a\Senoir 2\Design Patterns\Project\Charitable-Organization\models\UserModel.php');

$userModel = new User();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        // Create a new user
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $type = $_POST['type'];
        $userModel->createUser($userName, $password, $type);
    } elseif (isset($_POST['update'])) {
        // Update user information
        $id = $_POST['id'];
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $userModel->updateUser($id, $userName, $password);
    } elseif (isset($_POST['delete'])) {
        // Delete a user
        $id = $_POST['id'];
        $userModel->deleteUser($id);
    }
}

// Retrieve all users to display
$users = [];
$query = 'SELECT * FROM Users';
$stmt = (new Database())->getDbh()->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
</head>
<body>
    <h1>User Management</h1>

    <h2>Create New User</h2>
    <form method="POST">
        <input type="text" name="userName" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="type" required>
            <option value="Guest">Guest</option>
            <option value="RegisteredUserType">Registered User</option>
            <option value="Donor">Donor</option>
        </select>
        <button type="submit" name="create">Create User</button>
    </form>

    <h2>All Users</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['userName']); ?></td>
                    <td><?php echo htmlspecialchars($user['type']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <input type="text" name="userName" value="<?php echo htmlspecialchars($user['userName']); ?>" required>
                            <input type="password" name="password" placeholder="New Password" required>
                            <button type="submit" name="update">Update</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
