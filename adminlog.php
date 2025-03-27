<?php
// adminlog.php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['admin_email'];
  $password = $_POST['admin_password'];

  $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
  $stmt->execute([$email]);
  $admin = $stmt->fetch();

  // Removed password_verify for plain text comparison
  if ($admin && $password === $admin['password']) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    header('Location: admindash.php');  // Redirect to the updated admin dashboard
    exit();
  } else {
    echo 'Invalid admin credentials.';
  }
} else {
  header('Location: adminlog.html');
  exit();
}
?>
