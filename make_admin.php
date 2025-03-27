<?php
// make_admin.php
session_start();
require 'db.php';

// Only allow admins to access this page
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminlog.html');
    exit();
}

if (!isset($_GET['user_id'])) {
    echo "User ID not provided.";
    exit();
}

$user_id = $_GET['user_id'];

// Fetch user information from the users table
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit();
}

// Check if the user is already an admin (using the email as identifier)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = ?");
$stmt->execute([$user['email']]);
$isAdmin = $stmt->fetchColumn();

if ($isAdmin) {
    echo "This user is already an admin.";
    exit();
}

// Insert the user into the admins table (using the same name, email, and password)
$stmt = $pdo->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
if ($stmt->execute([$user['name'], $user['email'], $user['password']])) {
    echo "User has been successfully made an admin. <a href='admin_users.php'>Back to Manage Users</a>";
} else {
    echo "Failed to make user an admin.";
}
?>
