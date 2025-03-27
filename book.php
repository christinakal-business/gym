<?php
// book.php
session_start();
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.html');
  exit();
}

if (isset($_GET['class_id'])) {
  $class_id = $_GET['class_id'];
  
  // Check if the class_id exists in the classes table
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM classes WHERE id = ?');
  $stmt->execute([$class_id]);
  $classExists = $stmt->fetchColumn();

  if ($classExists) {
    // If class exists, proceed with booking
    $stmt = $pdo->prepare('INSERT INTO bookings (user_id, class_id) VALUES (?, ?)');
    
    if ($stmt->execute([$_SESSION['user_id'], $class_id])) {
      echo 'Class booked successfully. <a href="dashboard.php">Go to Dashboard</a>';
    } else {
      echo 'Error booking class. Please try again.';
    }
  } else {
    // If class does not exist, show an error
    echo 'Invalid class ID. Please try again.';
  }
} else {
  echo 'Invalid request. Class ID is missing.';
}
?>
