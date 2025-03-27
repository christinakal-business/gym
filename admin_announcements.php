<?php
// admin_announcements.php
session_start();
require 'db.php';

// Only allow admins to access this page
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminlog.html');
    exit();
}

// Handle announcement submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title'];
    $message = $_POST['message'];
    
    $stmt = $pdo->prepare("INSERT INTO announcements (title, message) VALUES (?, ?)");
    $stmt->execute([$title, $message]);
}

// Fetch announcements (most recent first)
$stmt = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC");
$announcements = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GymBeast - Manage Announcements</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Manage Announcements</h1>
    <nav>
      <ul>
        <li><a href="admindash.php">Dashboard</a></li>
        <li><a href="admin_messages.php">User Messages</a></li>
        <li><a href="admin_users.php">Manage Users</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="announcement-form">
      <h2>Create Announcement</h2>
      <form action="admin_announcements.php" method="POST">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required></textarea><br>
        <input type="submit" value="Post Announcement">
      </form>
    </section>
    <section class="announcements">
      <h2>Existing Announcements</h2>
      <?php if ($announcements): ?>
        <table>
          <tr>
            <th>Title</th>
            <th>Message</th>
            <th>Posted At</th>
          </tr>
          <?php foreach ($announcements as $ann): ?>
            <tr>
              <td><?php echo htmlspecialchars($ann['title']); ?></td>
              <td><?php echo htmlspecialchars($ann['message']); ?></td>
              <td><?php echo htmlspecialchars($ann['created_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
        <p>No announcements yet.</p>
      <?php endif; ?>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 GymBeast. All rights reserved.</p>
  </footer>
</body>
</html>
