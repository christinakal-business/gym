<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare('SELECT name, last_name, country, city, address, email, username FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch membership details
$stmt = $pdo->prepare('SELECT type, start_date, end_date FROM memberships WHERE user_id = ?');
$stmt->execute([$user_id]);
$membership = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch booked classes
$stmt = $pdo->prepare('
    SELECT classes.name, classes.time, classes.instructor 
    FROM bookings 
    JOIN classes ON bookings.class_id = classes.id 
    WHERE bookings.user_id = ?
');
$stmt->execute([$user_id]);
$booked_classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch announcements
$stmt = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC");
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GymBeast - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
        <nav>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="classes.html">Classes</a></li>
                <li><a href="membership.html">Membership</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- User Details Section -->
        <section class="dashboard-info">
            <h2>Welcome, <?php echo htmlspecialchars($user['name'] . ' ' . $user['last_name']); ?>!</h2>
            <h3>Your Details</h3>
            <p><strong>Country:</strong> <?php echo htmlspecialchars($user['country']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        </section>

        <!-- Membership Information Section -->
        <section class="membership-info">
            <h3>Your Membership</h3>
            <?php if ($membership): ?>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($membership['type']); ?></p>
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($membership['start_date']); ?></p>
                <p><strong>End Date:</strong> <?php echo htmlspecialchars($membership['end_date']); ?></p>
            <?php else: ?>
                <p>You don't have an active membership. <a href="membership.html">Get a Membership</a></p>
            <?php endif; ?>
        </section>

        <!-- Booked Classes Section -->
        <section class="booked-classes">
            <h3>Your Booked Classes</h3>
            <?php if (!empty($booked_classes)): ?>
                <table>
                    <tr>
                        <th>Class Name</th>
                        <th>Time</th>
                        <th>Instructor</th>
                    </tr>
                    <?php foreach ($booked_classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['name']); ?></td>
                        <td><?php echo htmlspecialchars($class['time']); ?></td>
                        <td><?php echo htmlspecialchars($class['instructor']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>You haven't booked any classes yet. <a href="classes.html">Browse Classes</a></p>
            <?php endif; ?>
        </section>

        <!-- Announcements Section -->
        <section class="announcements">
            <h3>Announcements</h3>
            <?php if (!empty($announcements)): ?>
                <ul>
                    <?php foreach ($announcements as $ann): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($ann['title']); ?></strong>
                        (<?php echo htmlspecialchars($ann['created_at']); ?>):<br>
                        <?php echo nl2br(htmlspecialchars($ann['message'])); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No announcements available.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 GymBeast. All rights reserved.</p>
    </footer>
</body>
</html>
