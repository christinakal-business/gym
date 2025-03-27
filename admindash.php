<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('Location: adminlog.html');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GymBeast - Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Admin Dashboard</h1>
    <nav>
      <ul>
        <li><a href="admindash.php">Dashboard</a></li>
        <li><a href="admin_users.php">Manage Users</a></li>
        <li><a href="admin_messages.php">User Messages</a></li>
        <li><a href="admin_announcements.php">Manage Announcements</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="admin-info">
      <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</h2>
      <p>Manage the gym, classes, users and more from here.</p>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 GymBeast. All rights reserved.</p>
  </footer>
</body>
</html>
