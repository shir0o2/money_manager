<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        header("Location: register.php?error=1");
        exit();
    }
    
    // Check if username exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0) {
        header("Location: register.php?error=2");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashed_password]);
    
    header("Location: index.php?registered=1");
    exit();
}
?>