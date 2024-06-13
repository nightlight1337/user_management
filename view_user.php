<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: authenticate.php');
    exit;
}

require 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<h1>User Details</h1>
<p>Username: <?= htmlspecialchars($user['username']) ?></p>
<p>First Name: <?= htmlspecialchars($user['first_name']) ?></p>
<p>Last Name: <?= htmlspecialchars($user['last_name']) ?></p>
<p>Gender: <?= htmlspecialchars($user['gender']) ?></p>
<p>Birth Date: <?= htmlspecialchars($user['birth_date']) ?></p>
<a href="index.php">Back to list</a>