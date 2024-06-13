<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: authenticate.php');
    exit;
}

require 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
$stmt->execute([$id]);

header('Location: index.php');
exit;
