<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: authenticate.php');
    exit;
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];

    $stmt = $pdo->prepare('INSERT INTO users (username, password, first_name, last_name, gender, birth_date) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$username, $password, $first_name, $last_name, $gender, $birth_date]);

    header('Location: index.php');
    exit;
}
?>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name">
    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name">
    <label for="gender">Gender:</label>
    <select id="gender" name="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>
    <label for="birth_date">Birth Date:</label>
    <input type="date" id="birth_date" name="birth_date">
    <button type="submit">Add User</button>
</form>