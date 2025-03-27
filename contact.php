<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get form data (no need to htmlspecialchars here – do that on output)
  $name    = $_POST['name'];
  $email   = $_POST['email'];
  $message = $_POST['message'];
  
  // Insert the message into the messages table
  $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
  if ($stmt->execute([$name, $email, $message])) {
      echo "Thank you, " . htmlspecialchars($name) . ". We have received your message.";
  } else {
      echo "There was an error sending your message. Please try again.";
  }
} else {
  header('Location: contact.html');
  exit();
}
?>
