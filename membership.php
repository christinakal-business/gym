<?php
session_start();
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

if (isset($_POST['membership_type'])) {
    $user_id = $_SESSION['user_id'];
    $membership_type = $_POST['membership_type'];

    // Set membership duration (1 year from today)
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime('+1 year'));

    // Check if user already has a membership
    $stmt = $pdo->prepare("SELECT id FROM memberships WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $existingMembership = $stmt->fetch();

    if ($existingMembership) {
        // Update existing membership
        $stmt = $pdo->prepare("UPDATE memberships SET type = ?, start_date = ?, end_date = ? WHERE user_id = ?");
        $stmt->execute([$membership_type, $start_date, $end_date, $user_id]);
    } else {
        // Insert new membership
        $stmt = $pdo->prepare("INSERT INTO memberships (user_id, type, start_date, end_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $membership_type, $start_date, $end_date]);
    }

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit();
} else {
    echo "Error: No membership type selected.";
}
?>
