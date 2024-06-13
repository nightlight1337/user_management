<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: authenticate.php');
    exit;
}

require 'db.php';

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET username = ?, password = ?, first_name = ?, last_name = ?, gender = ?, birth_date = ? WHERE id = ?');
        $stmt->execute([$username, $password, $first_name, $last_name, $gender, $birth_date, $id]);
    } else {
        $stmt = $pdo->prepare('UPDATE users SET username = ?, first_name = ?, last_name = ?, gender = ?, birth_date = ? WHERE id = ?');
        $stmt->execute([$username, $first_name, $last_name, $gender, $birth_date, $id]);
    }

    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    <label for="password">Password (leave blank to keep current password):</label>
    <input type="password" id="password" name="password">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">
    <label for="gender">Gender:</label>
    <select id="gender" name="gender">
        <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
        <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
    </select>
    <label for="birth_date">Birth Date:</label>
    <input type="date" id="birth_date" name="birth_date" value="<?= htmlspecialchars($user['birth_date']) ?>">
    <button type="submit">Update User</button>
</form>