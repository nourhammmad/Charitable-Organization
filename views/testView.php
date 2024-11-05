<?php
require_once "../models/UserModel.php";


//$userModel = new User();
function generate_uuid() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $uuid=generate_uuid();
        // Create a new user
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $type = $_POST['type'];
        User::createDefaultUser($uuid, $type);
        
    }
    // } elseif (isset($_POST['update'])) {
    //     // Update user information
    //     $id = $_POST['id'];
    //     $userName = $_POST['userName'];
    //     $password = $_POST['password'];
    //     $userModel->updateUser($id, $userName, $password);
    // } elseif (isset($_POST['delete'])) {
    //     // Delete a user
    //     $id = $_POST['id'];
    //     $userModel->deleteUser($id);
    // }
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
