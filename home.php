<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GymBeast - Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>GymBeast</h1>
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="classes.html">Classes</a></li>
        <li><a href="membership.html">Membership</a></li>
        <li><a href="contact.html">Contact</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html">Login</a></li>
        <?php endif; ?>
        
      </ul>
    </nav>
  </header>
  <main>
    <section class="hero">
      <h2>Achieve Your Fitness Goals</h2>
      <p>Join GymBeast today and start your journey to a healthier life!</p>
      
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php" class="btn">Go to Dashboard</a>
      <?php endif; ?>
      
    </section>
  </main>
  <footer>
    <p>&copy; 2025 GymBeast. All rights reserved.</p>
  </footer>
</body>
</html>
