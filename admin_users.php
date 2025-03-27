<?php
// admin_users.php
session_start();
require 'db.php';

// Only allow admins to access this page
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminlog.html');
    exit();
}

// Fetch all users from the users table
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GymBeast - Manage Users</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Manage Users</h1>
    <nav>
      <ul>
        <li><a href="admindash.php">Dashboard</a></li>
        <li><a href="admin_messages.php">User Messages</a></li>
        <li><a href="admin_announcements.php">Manage Announcements</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="users">
      <h2>Registered Users</h2>
      <?php if ($users): ?>
        <table>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?php echo htmlspecialchars($user['id']); ?></td>
              <td><?php echo htmlspecialchars($user['name']); ?></td>
              <td><?php echo htmlspecialchars($user['email']); ?></td>
              <td>
                <a href="make_admin.php?user_id=<?php echo $user['id']; ?>" 
                   onclick="return confirm('Are you sure you want to make this user an admin?');">
                  Make Admin
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
        <p>No users found.</p>
      <?php endif; ?>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 GymBeast. All rights reserved.</p>
  </footer>
</body>
</html>
