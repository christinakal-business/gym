<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password']; // No hashing as per your request

    // Check if email or username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    if ($stmt->fetch()) {
        echo "Email or username already taken.";
        exit();
    }

    // Insert user into database
    $stmt = $pdo->prepare("INSERT INTO users (name, last_name, country, city, address, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $last_name, $country, $city, $address, $email, $username, $password]);

    echo "Registration successful. <a href='login.html'>Login here</a>";
} else {
    echo "Invalid request.";
}
?>


