<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: authenticate.php');
    exit;
}

require 'db.php';

$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT * FROM users LIMIT $start, $limit");
$stmt->execute();
$users = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
$stmt->execute();
$total = $stmt->fetchColumn();
$pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Management</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <h1>User Management</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Birth Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                    <td><?= htmlspecialchars($user['last_name']) ?></td>
                    <td><?= htmlspecialchars($user['gender']) ?></td>
                    <td><?= htmlspecialchars($user['birth_date']) ?></td>
                    <td>
                        <a href="view_user.php?id=<?= $user['id'] ?>">View</a>
                        <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a>
                        <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="index.php?page=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <a href="add_user.php">Add New User</a>
    <a href="logout.php">Logout</a>
</body>

</html>