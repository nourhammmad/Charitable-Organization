<?php
require_once "D:\engineering ASU\computer year 4\Fall 24\Software Design Patterns\CharetyOrg\Charitable-Organization\models\UserModel.php";
 
// Test creating a default user
function testCreateDefaultUser() {
    $result = UserModel::createDefaultUser('123', 'regular');
    echo $result ? "Create Default User: Success\n" : "Create Default User: Failed\n";
}
 
// Test retrieving a user by ID
function testGetUserById($id) {
    $user = UserModel::getUserById($id);
    if ($user) {
        echo "Get User by ID: Success\n";
        print_r($user);
    } else {
        echo "Get User by ID: Failed\n";
    }
}
 
// Test deleting a user
function testDeleteUser($id) {
    $userModel = new UserModel();
    $result = $userModel->deleteUser($id);
    echo $result ? "Delete User: Success\n" : "Delete User: Failed\n";
}
 
// Test retrieving a user by email and password
function testGetByEmailAndPassword($email, $password) {
    $user = UserModel::get_by_email_and_password($email, $password);
    if ($user) {
        echo "Get User by Email and Password: Success\n";
        print_r($user);
    } else {
        echo "Get User by Email and Password: Failed\n";
    }
}
 
// Run tests
testCreateDefaultUser();
testGetUserById('123');
testDeleteUser('123');
testGetByEmailAndPassword('test@example.com', 'password123');
?>