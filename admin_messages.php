<?php
// admin_messages.php
session_start();
require 'db.php';

// Only allow admins to access this page
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminlog.html');
    exit();
}

// Fetch all messages (most recent first)
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GymBeast - User Messages</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>User Messages</h1>
    <nav>
      <ul>
        <li><a href="admindash.php">Dashboard</a></li>
        <li><a href="admin_users.php">Manage Users</a></li>
        <li><a href="admin_announcements.php">Manage Announcements</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="messages">
      <h2>Messages from Users</h2>
      <?php if ($messages): ?>
        <table>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Sent At</th>
          </tr>
          <?php foreach ($messages as $msg): ?>
            <tr>
              <td><?php echo htmlspecialchars($msg['name']); ?></td>
              <td><?php echo htmlspecialchars($msg['email']); ?></td>
              <td><?php echo htmlspecialchars($msg['message']); ?></td>
              <td><?php echo htmlspecialchars($msg['created_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
        <p>No messages found.</p>
      <?php endif; ?>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 GymBeast. All rights reserved.</p>
  </footer>
</body>
</html>
